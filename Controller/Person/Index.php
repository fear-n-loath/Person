<?php
declare(strict_types=1);

namespace Elogic\Person\Controller\Person;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Elogic\Person\Controller\Person
 */
class Index implements HttpGetActionInterface
{
    /** @var PageFactory */
    protected PageFactory $resultPageFactory;

    /**
     * Index constructor.
     * @param PageFactory $resultPageFactory
     */
    public function __construct(PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return Page|ResultInterface
     */
    public function execute()
    {
        return $this->resultPageFactory->create();
    }
}
