		<div class="btn btn-mini btn-group is2-dropdownmenu">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a tabindex="-1" class="is2-dropdownmenu-trigger" href="#" data-field-name="apellido" data-orderby="asc">
						<i class="icon-ok" style="display:<?php echo $orderByType == 'ASC' ? 'inline-bloc' : 'none'; ?>"></i>
						Ordernar por apellido vía ascendente
					</a>
				</li>
				<li>
					<a tabindex="-1" class="is2-dropdownmenu-trigger" href="#" data-field-name="apellido" data-orderby="desc">
						<i class="icon-ok" style="display:<?php echo $orderByType == 'DESC' ? 'inline-bloc' : 'none'; ?>"></i>
						Ordernar por apellido vía descendente
				</a>
				</li>
			</ul>
		</div>