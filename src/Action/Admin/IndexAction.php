<?php

namespace Stagem\ZfcLang\Action\Admin;

use Stagem\ZfcCmsBlock\Service\CmsBlockService;
use Popov\ZfcCurrent\CurrentHelper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Fig\Http\Message\RequestMethodInterface;
use Stagem\ZfcLang\Block\Grid\LangGrid;
use Stagem\ZfcCmsPage\Service\CmsPageService;
use Stagem\ZfcLang\LangHelper;
use Stagem\ZfcLang\Service\LangService;
use Zend\View\Model\ViewModel;

class IndexAction implements MiddlewareInterface, RequestMethodInterface
{
    /**
     * @var LangService
     */
    protected $langService;

    /**
     * @var CurrentHelper
     */
    protected $currentHelper;

    /** @var LangHelper */
    protected $langHelper;

    protected $langGrid;

    protected $config;

    public function __construct(LangService $langService, LangGrid $langGrid, LangHelper $langHelper, CurrentHelper $currentHelper/*, array $config*/)
    {
        $this->langService = $langService;
        $this->langGrid = $langGrid;
        $this->currentHelper = $currentHelper;
        $this->langHelper = $langHelper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $langs = $this->langService->getRepository()->getLangs();

        $this->langGrid->init();
        $productDataGrid = $this->langGrid->getDataGrid();
        $productDataGrid->setDataSource($langs);
        $productDataGrid->render();

        $response = $productDataGrid->getResponse();
        return $handler->handle($request->withAttribute(ViewModel::class, $response));
    }
}
