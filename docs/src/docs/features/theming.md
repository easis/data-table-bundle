# Theming

Every HTML part of this bundle can be customized using [Twig](https://twig.symfony.com/) themes.

[[toc]]

## Built-in themes

The following themes are natively available in the bundle:

- [`@KreyuDataTable/themes/bootstrap_5.html.twig`](https://github.com/Kreyu/data-table-bundle/blob/main/src/Resources/views/themes/bootstrap_5.html.twig) - integrates [Bootstrap 5](https://getbootstrap.com/docs/5.0/);
- [`@KreyuDataTable/themes/tabler.html.twig`](https://github.com/Kreyu/data-table-bundle/blob/main/src/Resources/views/themes/tabler.html.twig) - integrates [Tabler UI Kit](https://tabler.io/);
- [`@KreyuDataTable/themes/base.html.twig`](https://github.com/Kreyu/data-table-bundle/blob/main/src/Resources/views/themes/base.html.twig) - base HTML template;

By default, the [`@KreyuDataTable/themes/base.html.twig`](https://github.com/Kreyu/data-table-bundle/blob/main/src/Resources/views/themes/base.html.twig) theme is used.

## Selecting a theme

To select a theme, use `themes` option.

For example, in order to use the [Bootstrap 5](https://getbootstrap.com/docs/5.0/) theme:

::: code-group
```yaml [Globally (YAML)]
kreyu_data_table:
  defaults:
    themes:
      - '@KreyuDataTable/themes/bootstrap_5.html.twig'
```

```php [Globally (PHP)]
use Symfony\Config\KreyuDataTableConfig;

return static function (KreyuDataTableConfig $config) {
    $config->defaults()->themes([
        '@KreyuDataTable/themes/bootstrap_5.html.twig',
    ]);
};
```

```php [For data table type]
use Kreyu\Bundle\DataTableBundle\Type\AbstractDataTableType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductDataTableType extends AbstractDataTableType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'themes' => [
                '@KreyuDataTable/themes/bootstrap_5.html.twig',
            ],
        ]);
    }
}
```

```php [For specific data table]
use App\DataTable\Type\ProductDataTableType;
use Kreyu\Bundle\DataTableBundle\DataTableFactoryAwareTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    use DataTableFactoryAwareTrait;
    
    public function index()
    {
        $dataTable = $this->createDataTable(
            type: ProductDataTableType::class, 
            query: $query,
            options: [
                'themes' => [
                    '@KreyuDataTable/themes/bootstrap_5.html.twig',
                ],
            ],
        );
    }
}
```
:::

## Customizing existing theme

To customize existing theme, you can either:

- create a template that extends one of the built-in themes;
- create a template that [overrides the built-in theme](https://symfony.com/doc/current/bundles/override.html#templates);
- create a template from scratch;

Because `themes` configuration option accepts an array of themes,
you can provide your own theme with only a fraction of Twig blocks,
using the built-in themes as a fallback, for example:

```twig
{# templates/data_table/theme.html.twig #}
{% block column_boolean_value %}
    {# ... #}
{% endblock %}
```

::: code-group
```yaml [Globally (YAML)]
kreyu_data_table:
  defaults:
    themes:
      - '@KreyuDataTable/themes/bootstrap_5.html.twig'
```

```php [Globally (PHP)]
use Symfony\Config\KreyuDataTableConfig;

return static function (KreyuDataTableConfig $config) {
    $config->defaults()->themes([
        'templates/data_table/theme.html.twig',
        '@KreyuDataTable/themes/bootstrap_5.html.twig',
    ]);
};
```

```php [For data table type]
use Kreyu\Bundle\DataTableBundle\Type\AbstractDataTableType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductDataTableType extends AbstractDataTableType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'themes' => [
                'templates/data_table/theme.html.twig',
                '@KreyuDataTable/themes/bootstrap_5.html.twig',
            ],
        ]);
    }
}
```

```php [For specific data table]
use App\DataTable\Type\ProductDataTableType;
use Kreyu\Bundle\DataTableBundle\DataTableFactoryAwareTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    use DataTableFactoryAwareTrait;
    
    public function index()
    {
        $dataTable = $this->createDataTable(
            type: ProductDataTableType::class, 
            query: $query,
            options: [
                'themes' => [
                    'templates/data_table/theme.html.twig',
                    '@KreyuDataTable/themes/bootstrap_5.html.twig',
                ],
            ],
        );
    }
}
```
:::