{% extends "templates/index_2.volt" %}
{% block header %}
    {{ super() }}
	{# Hover #}
    {{ stylesheet_link('vendors/hover-effect-ideas/css/set2.css') }}
{% endblock %}
{% block body %}
	<div class="big-space"></div>
	<div class="row">
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="{{url('account')}}">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="{{url('')}}images/company-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Perfiles de <span>Cuentas</span></div>
							<p>Administre todas las cuentas de la aplicación</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="{{url('user')}}">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="{{url('')}}images/user-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Perfiles de <span>usuarios</span></div>
							<p>Administre los usuarios de la cuenta</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="{{url('imagebank')}}">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="{{url('')}}images/bank-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Banco de <span>imágenes</span></div>
							<p>Administre las imágenes que aparecen en el inicio de sesión de la aplicación</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
		
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="{{url('paymentplan')}}">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="{{url('')}}images/payment-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Planes de <span>pago</span></div>
							<p>Administre los planes de pago que se ofrecen a los clientes</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="{{url('ciuucode')}}">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="{{url('')}}images/industry-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Actividades <span>economicas</span></div>
							<p>Administre las actividades economicas a las que pueden pertenecer las compañias</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			 <a href="{{url('')}}permissionsystem#/resources">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="{{url('')}}images/security-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Permisos de <span>usuario</span></div>
							<p>Administre los permisos de cada usuario en la aplicación</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
	
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
			<a href="{{url('report')}}">
				 <div class="grid">
					<figure class="effect-duke">
						<img src="{{url('')}}images/report-image.jpg" alt="company-images">
						<figcaption>
							<div class="title">Administración de <span>reportes</span></div>
							<p>Cree, edite o elimine reportes de la aplicación</p>
						</figcaption>			
					</figure>
				</div>
			 </a>
		</div>
	</div>
    <div class="big-space"></div>
{% endblock%}