<?php
    if(!empty($errors)){
        echo '<pre>';
        print_r($errors);
    }
?>
<form action="{{route('testval')}}" method="POST">
    {{csrf_field()}}
    <input type="text" name="1"><br/>
    <input type="text" name="2"><br/>
    <input type="submit" name="3" value="submit"><br/>
</form>