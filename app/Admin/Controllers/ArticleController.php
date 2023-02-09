<?php

namespace App\Admin\Controllers;

use App\Models\Article;
use App\Models\ArticleType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ArticleController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Article';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article());

        $grid->title();
        $grid->column('article.title', 'Category');
        $grid->sub_title();
        $grid->column('description', __('Description'))->display(function ($val) {
            return substr($val, 0, 300);
        });
        $grid->column('released', "Released")->bool();
        $grid->column('thumbnail', __('Thumbnail'))->image('', '60', '60');
        $grid->filter(function ($filter) {
            $filter->disableIdfilter();
            $filter->like('title', __('Title'));
            $filter->like('article.title', __('Category'));
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Article::findOrFail($id));



        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article());
        $form->select('type_id', __('Category'))->options((new ArticleType())::selectOptions());
        $form->text('title', __('Title'))->required();
        $form->text('sub_title', __('Sub Title'));
        $form->image('thumbnail')->move('/programming');
        $form->UEditor('description', __('Content'))->required();
        $states = [
            'on' => ['value' => 1, 'text' => 'publish'],
            'off' => ['value' => 0, 'text' => 'draft']
        ];
        $form->switch('released', __('Publish'))->states($states);



        return $form;
    }
}
