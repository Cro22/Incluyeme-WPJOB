<?php
/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */

function incluyeme_filters_adminPage()
{
	$incluyemeFilters = 'incluyemeFiltersCV';
	$incluyemeNames = 'incluyemeNamesCV';
	if (isset($_POST['codeIncluyeme'])) {
		$value = $_POST['codeIncluyeme'];
		update_option($incluyemeFilters, sanitize_text_field($value));
		update_option($incluyemeFilters, sanitize_text_field($value));
	}
	if (isset($_POST['nameIncluyeme'])) {
		$value = $_POST['nameIncluyeme'];
		update_option($incluyemeNames, sanitize_text_field($value));
		update_option($incluyemeNames, sanitize_text_field($value));
	}
	?>
	<div class="container">
		<div class="card">
			<div class="card-title">
				<h5>Configuración General</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col">
						<form method="POST">
							<div class="row">
								<div class="col-12">
									<label for="codeIncluyeme"><b><?php _e("Ingrese el nombre del campo Certificado de Discapacidad", "wpjobboard"); ?></b></label>
									<input type="text"
									       class="form-control"
									       id="codeIncluyeme"
									       name="codeIncluyeme"
									       value="<?php echo get_option($incluyemeFilters) ? get_option($incluyemeFilters) : ''; ?>"
									       placeholder="<?php _e("Field Name.", "wpjobboard"); ?>">
									
									<span class="mt-2">El nombre del campo lo podra conseguir en la pagina de configuracion para
					                  los campos personalizados del plugin WPJob Board</span>
								</div>
								<div class="col-12 mt-2">
									<label for="nameIncluyeme"><b><?php _e("Ingrese nombre a mostrar para los certificados", "wpjobboard"); ?></b></label>
									<input type="text"
									       class="form-control"
									       id="nameIncluyeme"
									       name="nameIncluyeme"
									       value="<?php echo get_option($incluyemeNames) ? get_option($incluyemeNames) : 'C.U.D'; ?>"
									       placeholder="<?php _e("C.U.D", "wpjobboard"); ?>">
									<span class="mt-2">El valor que coloque aqui se mostrara en los filtros avanzados</span>
								</div>
							</div>
							<div class="text-right mt-2">
								<button type="submit"
								        class="btn btn-info"><?php _e("Guardar", "wpjobboard"); ?></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

function incluyeme_styles($hook)
{
	$current_screen = get_current_screen();
	if (!strpos($current_screen->base, 'incluyemefilters')) {
		return;
	} else {
		$css = plugins_url() . '/incluyeme/include/assets/css/';
		wp_register_style('bootstrap-admin', $css . 'bootstrap.min.css', [], '1.0.0', false);
		wp_enqueue_style('bootstrap-admin');
	}
}

function incluyemeSave_Options()
{
	$incluyemeFilters = 'incluyemeFiltersCV';
	if (isset($_POST['codeIncluyeme'])) {
		$value = $_POST['codeIncluyeme'];
		update_option($incluyemeFilters, sanitize_text_field($value));
		update_option($incluyemeFilters, sanitize_text_field($value));
	}
	
	wp_redirect(get_current_screen());
	exit;
}

add_action('admin_post_my_test_sub_save', 'incluyemeSave_Options');