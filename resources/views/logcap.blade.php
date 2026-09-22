<form id="logout" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
$( document ).ready(function() {
    // alert('ok');
$('#logout').submit();
});
</script>