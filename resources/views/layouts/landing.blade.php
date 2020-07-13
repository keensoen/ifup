<!DOCTYPE html>
<html lang="en">
    @include('layouts.front.htmlheader')
	<body data-spy="scroll" data-target=".navbar-fixed-top">
		<!-- Start Preloader Area-->
		<div class="preloader-area">
			<div class="sk-cube-grid">
				<div class="sk-cube sk-cube1"></div>
				<div class="sk-cube sk-cube2"></div>
				<div class="sk-cube sk-cube3"></div>
				<div class="sk-cube sk-cube4"></div>
				<div class="sk-cube sk-cube5"></div>
				<div class="sk-cube sk-cube6"></div>
				<div class="sk-cube sk-cube7"></div>
				<div class="sk-cube sk-cube8"></div>
				<div class="sk-cube sk-cube9"></div>
			</div>
		</div>
		<!--/End Preloader Area-->
        @include('layouts.front.nav')
        
        @yield('content')
		
		@include('layouts.front.footer')

		@include('layouts.front.scripts')
	</body>
</html>