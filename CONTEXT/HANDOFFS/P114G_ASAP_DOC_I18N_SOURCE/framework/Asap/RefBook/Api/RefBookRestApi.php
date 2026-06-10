<?php

declare(strict_types=1);

namespace ASAP\RefBook\Api;

use ASAP\Http\Request;
use ASAP\Http\Response;
use ASAP\RefBook\Attribute\AsapRefBookClass;
use ASAP\RefBook\Attribute\AsapRefBookMethod;
use ASAP\RefBook\Contract\RefBookInspectableInterface;
use Throwable;

/**
 * PUBLIC RefBook REST API.
 *
 * Role:
 *   Expose ASAP framework documentation truth to ASAP_REF_BOOK through a
 *   read-only JSON REST boundary.
 *
 * Responsibility:
 *   Route RefBook REST requests to snapshot, domain, class, example and diagram
 *   payloads. It does not render HTML and does not scan from the RefBook app.
 */
#[AsapRefBookClass(
    domain: 'RefBook',
    role: 'Expose RefBook data through a read-only REST API',
    responsibility: 'Serve JSON RefBook payloads generated from ASAP Reflection, attributes, examples and diagrams.',
    contracts: [
        'Only GET requests are accepted.',
        'The API is read-only and never mutates framework source or documentation assets.',
        'Unknown endpoints and missing assets return explicit JSON errors.',
        'ASAP_REF_BOOK must consume this API instead of scanning ASAP sources directly.',
    ],
    examples: ['refbook-rest-api-client'],
    diagrams: ['refbook-rest-api-flow'],
    introducedIn: 'P113D1'
)]
final class RefBookRestApi implements RefBookInspectableInterface
{


    #[AsapRefBookMethod(
        role: 'Expose the RefBook domain for the REST API boundary',
        behavior: 'Returns the stable RefBook domain used by snapshot and API consumers.',
        preconditions: ['none'],
        postconditions: ['The returned domain is RefBook.'],
        sideEffects: ['none'],
        errors: ['none'],
        testRefs: ['tests/Contract/RefBookRestApiContractTest.php'],
        examples: ['refbook-rest-api-client'],
        diagrams: ['refbook-rest-api-flow'],
        introducedIn: 'P113D1A'
    )]
    public static function refBookDomain(): string
    {
        return 'RefBook';
    }
    public function __construct(private readonly RefBookRestSnapshotProvider $provider, private readonly RefBookDocumentationAssetRepository $assets)
    {
    }

    #[AsapRefBookMethod(
        role: 'Handle one RefBook REST request',
        behavior: 'Accepts a normalized ASAP HTTP request and returns a JSON response for one documented RefBook REST endpoint.',
        preconditions: ['The request method is GET.', 'The path starts with /api/refbook.'],
        postconditions: ['Returns an ASAP HTTP response with application/json content type.'],
        sideEffects: ['Reads framework and documentation files through the provider when data endpoints are requested.'],
        errors: ['ASAP_REFBOOK_REST_METHOD_NOT_ALLOWED', 'ASAP_REFBOOK_REST_NOT_FOUND', 'ASAP_REFBOOK_REST_ASSET_NOT_FOUND'],
        testRefs: ['tests/Contract/RefBookRestApiContractTest.php'],
        examples: ['refbook-rest-api-client'],
        diagrams: ['refbook-rest-api-flow'],
        introducedIn: 'P113D1'
    )]
    public function handle(Request $request): Response
    {
        if (strtoupper($request->method) !== 'GET') {
            return $this->jsonError(405, 'ASAP_REFBOOK_REST_METHOD_NOT_ALLOWED', 'Only GET is allowed by the read-only RefBook API.');
        }

        $path = $this->normalizePath($request->path);
        try {
            return match (true) {
                $path === '/health' => Response::json(['ok' => true, 'api_version' => RefBookRestSnapshotProvider::API_VERSION]),
                $path === '/snapshot' => Response::json($this->provider->snapshot()),
                $path === '/domains' => Response::json(['domains' => $this->provider->snapshot()['domains']]),
                $path === '/classes' => Response::json(['classes' => $this->provider->snapshot()['classes']]),
                str_starts_with($path, '/classes/') => $this->classResponse(substr($path, strlen('/classes/'))),
                str_starts_with($path, '/examples/') => $this->assetResponse('example', substr($path, strlen('/examples/'))),
                str_starts_with($path, '/diagrams/') => $this->assetResponse('diagram', substr($path, strlen('/diagrams/'))),
                default => $this->jsonError(404, 'ASAP_REFBOOK_REST_NOT_FOUND', 'Unknown RefBook REST endpoint: ' . $request->path),
            };
        } catch (Throwable $error) {
            return $this->jsonError(500, 'ASAP_REFBOOK_REST_INTERNAL_ERROR', $error->getMessage());
        }
    }

    private function classResponse(string $encodedFqcn): Response
    {
        $fqcn = rawurldecode($encodedFqcn);
        foreach ($this->provider->snapshot()['classes'] as $class) {
            if (($class['name'] ?? '') === $fqcn) {
                return Response::json(['class' => $class]);
            }
        }

        return $this->jsonError(404, 'ASAP_REFBOOK_REST_CLASS_NOT_FOUND', 'Class not found: ' . $fqcn);
    }

    private function assetResponse(string $type, string $encodedId): Response
    {
        $id = rawurldecode($encodedId);
        $asset = $type === 'diagram' ? $this->assets->diagram($id) : $this->assets->example($id);
        if ($asset === null) {
            return $this->jsonError(404, 'ASAP_REFBOOK_REST_ASSET_NOT_FOUND', strtoupper($type) . ' not found: ' . $id);
        }

        return Response::json([$type => $asset]);
    }

    private function normalizePath(string $path): string
    {
        if (!str_starts_with($path, '/api/refbook')) {
            return '/__not_found__';
        }
        $relative = substr($path, strlen('/api/refbook'));
        if ($relative === '') {
            return '/health';
        }

        return $relative;
    }

    private function jsonError(int $status, string $code, string $message): Response
    {
        return Response::json(['ok' => false, 'error' => ['code' => $code, 'message' => $message]], $status);
    }
}
