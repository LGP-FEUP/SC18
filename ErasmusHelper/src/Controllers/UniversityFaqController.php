<?php

namespace ErasmusHelper\Controllers;

use AgileBundle\Utils\Request;
use ErasmusHelper\App;
use ErasmusHelper\Models\City;
use ErasmusHelper\Models\UniversityFaq;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Kreait\Firebase\Exception\DatabaseException;

class UniversityFaqController extends UniModsBackOfficeController
{
    /**
     * @throws DatabaseException
     */
    public function displayAll()
    {
        $this->render("university_faq.list", ["university_faqs" => UniversityFaq::getAll()]);
    }

    /**
     * @throws DatabaseException
     */
    public function create()
    {
        $this->render("university_faq.create", ["university_faqs" => UniversityFaq::getAll()]);
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function createFaq()
    {
        $universityTooltip = new UniversityFaq();

        if (Request::valuePost("question") && Request::valuePost("reply") && Request::valuePost('order')) {
            $universityTooltip->id = App::UUIDGenerator();
            $universityTooltip->question = Request::valuePost("question");
            $universityTooltip->reply = Request::valuePost("reply");
            $universityTooltip->order = Request::valuePost("order");

            try {
                $this->increaseOrderNumbers($universityTooltip->order);
            } catch (DatabaseException) {
            }

            if ($universityTooltip->save())
                $this->redirect(Router::route("university_faqs"), ["success" => "Faq added successfully."]);
        }
        $this->redirect(Router::route("university_faqs"), ["error" => "Unable to add the faq."]);
    }


    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function delete($id)
    {
        $faq = UniversityFaq::select(["id" => $id]);
        if ($faq != null && $faq->exists()) {
            if ($faq->delete()) {
                $this->decreaseOrderNumbers($faq->order);
                $this->redirect(Router::route("university_faqs"), ["success" => "Faq deleted."]);
            }
        }
        $this->redirect(Router::route("university_faqs"), ["error" => "Failed to delete the faq."]);
    }

    /**
     * @throws DatabaseException
     */
    #[NoReturn] public function editFaq($id)
    {
        $faq = UniversityFaq::select(["id" => $id]);
        if (Request::valuePost("question") && Request::valuePost("reply") && Request::valuePost('order') && $faq && $faq->exists()) {
            $faq->name = Request::valuePost("name");
            $faq->country_id = Request::valuePost("country_id");

            if ($faq->order != Request::valuePost('order'))
                $this->updateOrderValues($faq->order, Request::valuePost('order'));

            $faq->order = Request::valuePost('order');

            if ($faq->save())
                $this->redirect(Router::route("university_faqs"), ["success" => "Faq edited."]);

        }
        $this->redirect(Router::route("university_faqs"), ["error" => "Unable to edit the faq."]);

    }

    /**
     * @throws DatabaseException
     */
    public function edit($id)
    {
        $this->render('university_faq.details', ['university_faq' => UniversityFaq::select(["id" => $id]), 'university_faqs' => UniversityFaq::getAll()]);
    }


    /**
     * @throws DatabaseException
     */
    private function increaseOrderNumbers($newValue)
    {

        $items = UniversityFaq::getAll();

        if (!isset($items))
            return;

        foreach (UniversityFaq::getAll() as $item) {
            if ($item->order >= $newValue) {
                $item->order++;
                $item->save();
            }
        }
    }

    /**
     * @throws DatabaseException
     */
    private function decreaseOrderNumbers($deletedValue)
    {
        $items = UniversityFaq::getAll();

        if (!isset($items))
            return;

        foreach (UniversityFaq::getAll() as $item) {
            if ($item->order > $deletedValue) {
                $item->order--;
                $item->save();
            }
        }

    }

    /**
     * @throws DatabaseException
     */
    private function updateOrderValues($originalValue, $newValue)
    {
        #There is a reduction

        $items = UniversityFaq::getAll();

        if (!isset($items))
            return;

        if ($originalValue > $newValue) {

            foreach ($items as $item) {
                if ($item->order >= $newValue && $item->order < $originalValue) {
                    $item->order++;
                    $item->save();
                }
            }
        } else {
            #There is an increase
            foreach ($items as $item) {
                if ($item->order <= $newValue && $item->order > $originalValue) {
                    $item->order--;
                    $item->save();
                }
            }
        }

    }
}

