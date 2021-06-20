<div class="container-fluid bg-light pb-3 rounded-bottom">
	<nav class="navbar navbar-expand-sm navbar-light border-bottom">
		<button class="navbar-toggler"  data-toggle="collapse" data-target="#collapsibleNavbar2">
			<span class="navbar-toggler-icon"></span>
		</button>
	<!-- Navbar links -->
		<div class="collapse navbar-collapse " id="collapsibleNavbar2">
			<ul class="navbar-nav d-flex" style="width:100%;">
				<li class="nav-item item-admin active ">
					<a class="nav-link" id="nav-link" onclick="changeFrame('administrator/data')" >Dados</a>
				</li>
				<li class="line-horizontal"></li>
				<li class="nav-item item-admin">
					<a class="nav-link" id="nav-link" onclick="changeFrame('group/register')">Criar Grupo</a>
				</li>
				<li class="line-horizontal"></li>
				<li class="nav-item item-admin">
					<a class="nav-link" id="nav-link" onclick="changeFrame('administrator/listGroup')">Lista dos Grupos</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="row p-2 h-90" >
		<div class="col-sm-12">
			<iframe src="<?=BASE_URL?>administrator/data" frameborder="0" class="frame-admin" id="frame_modify"></iframe>
		</div>
	</div>
</div>
<script>
var frameBefore;
document.getElementById('nav-link').removeAttribute("href");
function changeFrame(frame){
	
	console.log("<?=BASE_URL?>" + frame);
	if(frame != ""){
		frame = "<?=BASE_URL?>" + frame;
		document.getElementById('frame_modify').src = frame;
	}
}
</script>