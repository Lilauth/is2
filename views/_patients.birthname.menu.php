		<div class="btn btn-mini btn-group is2-dropdownmenu">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a tabindex="-1" class="is2-dropdownmenu-trigger" href="#" data-field-name="fecha-de-nacimiento" data-orderby="asc">
						<i class="icon-ok" style="display:<?php echo $orderByType == 'ASC' ? 'inline-block' : 'none'; ?>"></i>
						Ordernar por fecha de nacimiento más antigua
					</a>
				</li>
				<li>
					<a tabindex="-1" class="is2-dropdownmenu-trigger" href="#" data-field-name="fecha-de-nacimiento" data-orderby="desc">
						<i class="icon-ok" style="display:<?php echo $orderByType == 'DESC' ? 'inline-bloc' : 'none'; ?>"></i>
						Ordernar por fecha de nacimiento más reciente
					</a>
				</li>
			</ul>
		</div>