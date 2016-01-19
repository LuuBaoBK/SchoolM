<script src="{{asset("/adminlte/plugins/jQuery/jQuery-2.1.4.min.js")}}"></script>
<script src="{{asset("/adminlte/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- DataTables -->
<script src="{{asset("/adminlte/plugins/datatables/jquery.dataTables.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>
<script src="{{asset("/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")}}"></script>
<!-- CK Editor -->
<script src="{{asset("/mylib/ckeditor/ckeditor.js")}}"></script>
<!-- Pusher -->
<script src="{{asset("/mylib/bower_components/pusher/dist/pusher.min.js")}}"></script>

<button type="button" onclick="show()">Notify me!</button>
<script type="text/javascript">
	var Notification = window.Notification || window.mozNotification || window.webkitNotification;

	Notification.requestPermission(function (permission) {
		// console.log(permission);
	});

	function show() {
		var instance = new Notification(
			"123", {
				body: "321"
			}
		);

		instance.onclick = function () {
			// Something to do
		};
		instance.onerror = function () {
			// Something to do
		};
		instance.onshow = function () {
			// Something to do
		};
		instance.onclose = function () {
			// Something to do
		};
	}
</script>

<button type="button" onclick="show()">Notify me!</button>
