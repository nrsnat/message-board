<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;    // 追加 App\Models\Message のModel操作が主な役割のため

class MessagesController extends Controller
{
    // getでmessages/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        // メッセージ一覧を取得　App\Models\Message::all()　と書きたいところだけど名前空間が宣言されているから省略可
        $messages = Message::all();         // 追加
        
        // メッセージ一覧ビューでそれを表示
        return view('messages.index', [ 'messages' => $messages, ]);   //右のmessageはビューファイル側で呼び出す変数名 $messages に入ったデータをViewに渡す                             // 追加
    }

    // getでmessages/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        //インスタンス作成
        $message = new Message;
        // メッセージ作成ビューを表示
        return view('messages.create', [
            'message' => $message,
        ]);
    }

    // postでmessages/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // バリデーション　空ではない　かつ　255文字がmax
        //　バリデーションエラーが発生した場合、自動リダイレクトかつ$errors変数にメッセージが格納される
        $request->validate([
            'content' => 'required|max:255',
        ]);
        
        //メッセージを作成
        $message = new Message;
        $message->content = $request->content; //$request から content を取り出して、新規作成したメッセージインスタンスに代入・保存
        $message->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // getでmessages/（任意のid）にアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でメッセージを検索して取得
        $message = Message::findOrFail($id);

        // メッセージ詳細ビューでそれを表示
        return view('messages.show', [
            'message' => $message,
        ]);
    }

    // getでmessages/（任意のid）/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $message = Message::findOrFail($id);

        // メッセージ編集ビューでそれを表示
        return view('messages.edit', [
            'message' => $message,
        ]);
    }

    // putまたはpatchでmessages/（任意のid）にアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|max:255',
        ]);
        
        // idの値でメッセージを検索して取得
        $message = Message::findOrFail($id);
        // メッセージを更新
        $message->content = $request->content;
        $message->save();

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    // deleteでmessages/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でメッセージを検索して取得
        $message = Message::findOrFail($id);
        // メッセージを削除
        $message->delete();

        // トップページへリダイレクトさせる
        return redirect('/');
    }
}