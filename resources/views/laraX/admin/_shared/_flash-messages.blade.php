<script type="text/javascript">
    //flash message;
    @foreach(\TCH\LaraXConfig::messageType() as $type)
        <?php $messages = Session::get($type.'Messages')?>
        @continue(empty($messages))
        @foreach($messages as $key => $row)
            Utility.showNotification('{{ $row }}', '{{$type}}');
        @endforeach
    @endforeach
</script>
