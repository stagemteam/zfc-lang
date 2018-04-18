<?php

namespace Stagem\ZfcLang\Action\Admin;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stagem\ZfcCmsBlock\Service\CmsBlockService;
use Stagem\ZfcCmsPage\Form\Admin\CmsPageForm;
use Stagem\ZfcCmsPage\Service\CmsPageService;
use Stagem\ZfcLang\Form\Admin\LangForm;
use Stagem\ZfcLang\Service\LangService;
use Zend\Expressive\Helper\UrlHelper;
use Zend\View\Model\ViewModel;
use Popov\ZfcForm\FormElementManager;
use Zend\Diactoros\Response\RedirectResponse;
class EditAction
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
        /** @var \Stagem\Question\Model\Question $lang */
        $lang = ($lang = $this->langService->find($id = (int) $request->getAttribute('id')))
            ? $lang
            : $this->langService->getObjectModel();

        /** @var LangForm $form */
        $form = $this->fm->get(LangForm::class);
        $form->bind($lang);

        if ($request->getMethod() == 'POST') {
            $params = $request->getParsedBody();
            if (isset($params['remove'])) {
                $om = $this->langService->getObjectManager();
                $om->remove($lang);
                $om->flush();

                $flash = $request->getAttribute('flash');
                $flash->addMessage('Language has been removed successfully', 'success');

                return new RedirectResponse($this->urlHelper->generate('admin/default', [
                    'resource' => 'lang',
                    'action' => 'index'
                ]));
            } else {
                $form->setData($params);
                if ($form->isValid()) {
                    $this->langService->save($lang);

                    $flash = $request->getAttribute('flash');
                    $flash->addMessage('Language has been saved successfully', 'success');

                    return new RedirectResponse($this->urlHelper->generate('admin/default', [
                        'resource' => 'lang',
                        'action' => 'index'
                    ]));

                }
            }
        }

        $view = new ViewModel([
            'form' => $form,
        ]);

        return $handler->handle($request->withAttribute(ViewModel::class, $view));
    }
}