<?php

declare(strict_types=1);

namespace Opus\Recipe\Recipes;

use Opus\Recipe\RecipeContext;
use Opus\Recipe\RecipeInterface;

/** PUBLIC RECIPE: validate Opus core classes are autoloadable after namespace normalization. */
final class CoreAutoloadRecipe implements RecipeInterface
{
    public function name(): string { return 'core_autoload'; }

    public function run(RecipeContext $context): array
    {
        foreach ([
            \Opus\Core\Bootstrap::class,
            \Opus\Core\Kernel::class,
            \Opus\Application\ApplicationPaths::class,
            \Opus\Config\ConfigBag::class,
            \Opus\Contract\ContractException::class,
            \Opus\Http\Request::class,
            \Opus\Http\Response::class,
            \Opus\Renderer\ViewModel::class,
            \Opus\Validation\Validator::class,
        ] as $class) {
            $context->assert(class_exists($class), 'OPUS_CORE_CLASS_NOT_AUTOLOADABLE', $class);
        }

        $request = new \Opus\Http\Request('/demo', 'GET');
        $context->assert($request->path === '/demo', 'OPUS_CORE_REQUEST_INVALID');
        $response = \Opus\Http\Response::json(['ok' => true]);
        $context->assert($response->status === 200 && str_contains($response->body, 'true'), 'OPUS_CORE_RESPONSE_JSON_INVALID');

        return ['OPUS_CORE_OK'];
    }
}
