{% extends "templates/index_2.volt" %}
{% block header %}
    {{ super() }}
	{# Hover #}
    {{ stylesheet_link('vendors/hover-effect-ideas/css/set2.css') }}
{% endblock %}
{% block body %}
	<div class="big-space"></div>
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
			<a href="{{url('system/configure')}}">
				 <div class="grid">	
					<figure class="effect-goliath">
						<img src="{{url('')}}images/system.png" alt="system" />
						<figcaption>
							<h2>Configuración del <span>sistema</span></h2>
							<p>Configure los parametros en los que el sistema se basa para funcionar</p>
						</figcaption>			
					</figure>
				</div>
			</a>
		</div>
	</div>
    <div class="big-space"></div>
{% endblock%}