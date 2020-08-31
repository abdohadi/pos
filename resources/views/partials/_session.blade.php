@if (session('success'))

	<script type="text/javascript">
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 2000,
            killer: true
        }).show();
	</script>

@endif