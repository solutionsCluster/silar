{% if report.code == 'RPT-001'%}
	{{ partial('sales/partials/RPT-001')}}
{% elseif report.code == 'RPT-002'%}
	{{ partial('sales/partials/RPT-002')}}
{% elseif report.code == 'RS-003'%}
	{{ partial('sales/partials/RS-003')}}
{% elseif report.code == 'RS-004'%}
	{{ partial('sales/partials/RS-004')}}
{% elseif report.code == 'RS-005'%}
	{{ partial('sales/partials/RS-005')}}
{% elseif report.code == 'RS-006'%}
	{{ partial('sales/partials/RS-006')}}
{% elseif report.code == 'RS-007'%}
	{{ partial('sales/partials/RS-007')}}
{% elseif report.code == 'RS-008'%}
	{{ partial('sales/partials/RS-008')}}
{% elseif report.code == 'RP-001'%}
    {{ partial('portfolio/partials/RP-001')}}
{% elseif report.code == 'RI-001'%}
	{{ partial('inventories/partials/RI-001')}}
{% elseif report.code == 'RI-002'%}
	{{ partial('inventories/partials/RI-002')}}
{% elseif report.code == 'RI-003'%}
	{{ partial('inventories/partials/RI-003')}}
{% elseif report.code == 'RI-004'%}
	{{ partial('inventories/partials/RI-004')}}
{% elseif report.code == 'RI-005'%}
	{{ partial('inventories/partials/RI-005')}}
{% elseif report.code == 'RPT-003'%}
	{{ partial('sales/partials/RPT-003')}}
{% endif %}
