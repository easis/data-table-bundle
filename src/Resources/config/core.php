<?php

declare(strict_types=1);

use Kreyu\Bundle\DataTableBundle\Bridge\Doctrine\Orm\Query\DoctrineOrmProxyQueryFactory;
use Kreyu\Bundle\DataTableBundle\DataTableFactory;
use Kreyu\Bundle\DataTableBundle\DataTableFactoryInterface;
use Kreyu\Bundle\DataTableBundle\DataTableRegistry;
use Kreyu\Bundle\DataTableBundle\DataTableRegistryInterface;
use Kreyu\Bundle\DataTableBundle\Maker\MakeDataTable;
use Kreyu\Bundle\DataTableBundle\Persistence\StaticPersistenceSubjectProvider;
use Kreyu\Bundle\DataTableBundle\Persistence\TokenStoragePersistenceSubjectProvider;
use Kreyu\Bundle\DataTableBundle\Query\ChainProxyQueryFactory;
use Kreyu\Bundle\DataTableBundle\Query\ProxyQueryFactoryInterface;
use Kreyu\Bundle\DataTableBundle\Request\HttpFoundationRequestHandler;
use Kreyu\Bundle\DataTableBundle\Request\RequestHandlerInterface;
use Kreyu\Bundle\DataTableBundle\Type\DataTableType;
use Kreyu\Bundle\DataTableBundle\Type\ResolvedDataTableTypeFactory;
use Kreyu\Bundle\DataTableBundle\Type\ResolvedDataTableTypeFactoryInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $configurator) {
    $services = $configurator->services();

    $services
        ->set('kreyu_data_table.resolved_type_factory', ResolvedDataTableTypeFactory::class)
        ->alias(ResolvedDataTableTypeFactoryInterface::class, 'kreyu_data_table.resolved_type_factory')
    ;

    $services
        ->set('kreyu_data_table.type.data_table', DataTableType::class)
        ->tag('kreyu_data_table.type')
    ;

    $services
        ->set('kreyu_data_table.registry', DataTableRegistry::class)
        ->args([
            tagged_iterator('kreyu_data_table.type'),
            tagged_iterator('kreyu_data_table.type_extension'),
            service('kreyu_data_table.resolved_type_factory'),
        ])
        ->alias(DataTableRegistryInterface::class, 'kreyu_data_table.registry')
    ;

    $services
        ->set('kreyu_data_table.factory', DataTableFactory::class)
        ->args([
            service('kreyu_data_table.registry'),
            service('kreyu_data_table.proxy_query.factory.chain'),
        ])
        ->alias(DataTableFactoryInterface::class, 'kreyu_data_table.factory')
    ;

    $services
        ->set('kreyu_data_table.persistence.subject_provider.token_storage', TokenStoragePersistenceSubjectProvider::class)
        ->args([service('security.token_storage')])
    ;

    $services
        ->set('kreyu_data_table.persistence.subject_provider.static', StaticPersistenceSubjectProvider::class)
    ;

    $services
        ->set('kreyu_data_table.request_handler.http_foundation', HttpFoundationRequestHandler::class)
        ->alias(RequestHandlerInterface::class, 'kreyu_data_table.request_handler.http_foundation')
    ;

    $services
        ->set('kreyu_data_table.proxy_query.factory.chain', ChainProxyQueryFactory::class)
        ->args([
            tagged_iterator('kreyu_data_table.proxy_query.factory'),
        ])
        ->alias(ProxyQueryFactoryInterface::class, 'kreyu_data_table.query.proxy_query_factory.chain')
    ;


    $services
        ->set('kreyu_data_table.proxy_query.factory.doctrine_orm', DoctrineOrmProxyQueryFactory::class)
        ->tag('kreyu_data_table.proxy_query.factory')
    ;

    $services
        ->set('kreyu_data_table.maker', MakeDataTable::class)
        ->tag('maker.command')
    ;
};
