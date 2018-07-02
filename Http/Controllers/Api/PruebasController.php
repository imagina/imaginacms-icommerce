<?php

namespace Modules\Icommerce\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Comment;
use Modules\Icommerce\Http\Requests\CreateCommentRequest;
use Modules\Icommerce\Http\Requests\UpdateCommentRequest;
use Modules\Icommerce\Repositories\CommentRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PruebasController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function listaObj()
    {
        return [
            'nombre' => 'Oto',
            'apellido' => 'Marquez'
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('icommerce::admin.comments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCommentRequest $request
     * @return Response
     */
    public function store(CreateCommentRequest $request)
    {
        $this->comment->create($request->all());

        return redirect()->route('admin.icommerce.comment.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('icommerce::comments.title.comments')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Comment $comment
     * @return Response
     */
    public function edit(Comment $comment)
    {
        return view('icommerce::admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Comment $comment
     * @param  UpdateCommentRequest $request
     * @return Response
     */
    public function update(Comment $comment, UpdateCommentRequest $request)
    {
        $this->comment->update($comment, $request->all());

        return redirect()->route('admin.icommerce.comment.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('icommerce::comments.title.comments')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Comment $comment
     * @return Response
     */
    public function destroy(Comment $comment)
    {
        $this->comment->destroy($comment);

        return redirect()->route('admin.icommerce.comment.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('icommerce::comments.title.comments')]));
    }
}
