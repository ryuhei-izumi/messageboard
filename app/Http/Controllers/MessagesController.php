<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Message; 

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
         // getでmessages/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        //
          $messages = Message::all();

        return view('messages.index', [
            'messages' => $messages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //POST メソッドを送信する新規作成用の入力フォーム置き場
        $message = new Message;

        return view('messages.create', [
            'message' => $message,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [
            'title' => 'required|max:191',   
            'content' => 'required|max:191',
        ]);
        
        //create のページから送信されるフォームを処理する
        $message = new Message;
        $message->title = $request->title;   
        $message->content = $request->content;
        $message->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$id が指定されているので、 Message::find($id) によって1つだけ取得
         $message = Message::find($id);

        return view('messages.show', [
            'message' => $message,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // getでmessages/id/editにアクセスされた場合の「更新画面表示処理」
         $message = Message::find($id);

        return view('messages.edit', [
            'message' => $message,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:191',
            'content' => 'required|max:191',
        ]);
        //
        $message = Message::find($id);
        $message->title = $request->title;
        $message->content = $request->content;
        $message->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $message = Message::find($id);
        $message->delete();

        return redirect('/');
    }
}
