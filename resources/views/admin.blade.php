
{{-- resources/views/vue.blade.php --}}
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
	<title>Laravel 9 Vue 3</title>
</head>
<body>


<div id="app">

</div>



	<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
