@extends("layouts.app")
<style>
    * {
        font-family: tahoma;
        font-size: 12px;
        padding: 0px;
        margin: 0px;
    }

    .msg {
        line-height: 18px;
    }

    .chat_div {
        width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    #chat {
        padding: 5px;
        background: #ddd;
        border-radius: 5px;
        overflow-y: scroll;
        border: 1px solid #CCC;
        margin-top: 10px;
        height: 160px;
    }

    #chat_input {
        border-radius: 2px;
        border: 1px solid #ccc;
        margin-top: 10px;
        padding: 5px;
        width: 400px;
    }

    #status {
        width: 88px;
        display: block;
        float: left;
        margin-top: 15px;
    }
</style>
@section("content")

    <div id="chat" class="chat_div"></div>
    <div class="chat_div">
        <span id="status">Connecting...</span>
        <input type="text" id="chat_input" disabled="disabled"/>
    </div>
@endsection


@section("scripts")
    <script src="{{asset("js/chat_scripts/chat.js")}}"></script>
@endsection
