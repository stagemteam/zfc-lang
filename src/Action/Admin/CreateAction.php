<?php

namespace Stagem\ZfcLang\Action\Admin;

use Fig\Http\Message\RequestMethodInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stagem\ZfcLang\Form\Admin\LangForm;
use Stagem\ZfcLang\Service\LangService;
use Zend\Expressive\Helper\UrlHelper;
use Zend\View\Model\ViewModel;
use Popov\ZfcForm\FormElementManager;
use Zend\Diactoros\Response\RedirectResponse;

class CreateAction implements MiddlewareInterface, RequestMethodInterface
{
    /* @var LangService */
    protected $langService;

    /* @var UrlHelper */
    protected $urlHelper;

    /** @var FormElementManager */
    protected $fm;

    public function __construct(LangService $langService, UrlHelper $urlHelper, FormElementManager $fm)
    {
        $this->langService = $langService;
        $this->urlHelper = $urlHelper;
        $this->fm = $fm;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $form = $this->fm->get(LangForm::class);
        if ($request->getMethod() == 'POST') {
            $lang = $this->langService->getObjectModel();
            $form->bind($lang);
            $fields = $request->getParsedBody();

            $form->setData($fields);

            if ($form->isValid()) {
                $this->langService->save($lang);

                $flash = $request->getAttribute('flash');
                $flash->addMessage('Language has been created successfully', 'success');

                $redirect = [
                    'route' => 'admin/default',
                    'params' => [
                        'resource' => 'lang',
                        'action' => 'index',
                    ],
                ];
                return new RedirectResponse($this->urlHelper->generate($redirect['route'], $redirect['params']));
            }

        }

        $view = new ViewModel([
            'form' => $form,
        ]);
        return $handler->handle($request->withAttribute(ViewModel::class, $view));
    }
}