@if (session('alert')=="lobibox" && session('type') && session('title') && session('msg'))
<script type="text/javascript">
	Lobibox.notify('{{ session('type') }}', {
		size: '@if(session('size')){{ session('size') }}@else{{ "normal" }}@endif',
		title: '{{ session('title') }}',
		sound: true,
		msg: '{{ session('msg') }}',
		position: '@if(session('position')){{ session('position') }}@else{{ "bottom right" }}@endif',
		delay: @if(session('delay')){{ session('delay') }}@else{{ 5000 }}@endif,
		messageHeight: @if(session('messageHeight')){{ session('messageHeight') }}@else{{ 60 }}@endif
	});
</script>
@elseif (session('alert')=="sweet" && session('type') && session('title') && session('msg'))
<script type="text/javascript">
	swal({
      title: '{{ session('title') }}',
      text: "{{ session('msg') }}",
      type: '{{ session('type') }}',
      padding: '2em'
    })
</script>
@endif