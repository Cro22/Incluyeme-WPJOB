<?php
/**
 * Copyright (c) 2020.
 * Jesus Nuñez <Jesus.nunez2050@gmail.com>
 */

/**
 * Company job applications
 *
 * Template displays job applications
 *
 *
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 *
 */

/* @var $applicantList array List of applications to display */
/* @var $job string Wpjb_Model_Job */

?>
	
	<div class="wpjb wpjb-page-job-applications" id="incluyeme-wpjb">
		
		<?php wpjb_flash(); ?>
		<?php wpjb_breadcrumbs($breadcrumbs) ?>
		<div class="container">
			<div class="row">
				<div class="col-10">
					<div id="wpjb-top-search" class="wpjb-layer-inside wpjb-filter-applications">
						<form action="<?php echo esc_attr(wpjb_link_to("job_applications")) ?>" method="GET">
							<?php global $wp_rewrite ?>
							<?php if (!$wp_rewrite->using_permalinks()): ?>
								<input type="hidden" name="page_id" value="<?php echo $page_id ?>"/>
								<input type="hidden" name="job_board" value="find"/>
							<?php endif; ?>
							<div class="wpjb-search wpjb-search-group-visible">
								<div class="wpjb-input wpjb-input-type-half wpjb-input-type-half-left">
									<select name="job_id">
										<option value=""><?php _e("All Jobs", "wpjobboard") ?></option>
										<?php foreach ($jobsList as $job): ?>
											<option value="<?php echo esc_html($job->id) ?>" <?php selected($job->id, $job_id) ?>><?php echo esc_html($job->job_title) ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								
								<div class="wpjb-input wpjb-input-type-half wpjb-input-type-half-left">
									<select name="job_status">
										<option value=""><?php _e("All Statuses", "wpjobboard") ?></option>
										<?php foreach ($public_ids as $status_id): ?>
											<?php $status = wpjb_get_application_status($status_id) ?>
											<option value="<?php echo esc_html($status_id) ?>" <?php selected($job_status, $status_id) ?>><?php echo esc_html($status["label"]) ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="wpjb-list-search">
								<a href="#" class="wpjb-button wpjb-button-search wpjb-button-submit"
								   v-on:click='message=false'
								   title="<?php _e("Filter Results", "wpjobboard") ?>">
									<span class="wpjb-glyphs wpjb-icon-search"></span>
									<span class="wpjb-mobile-only"><?php _e("Filter Results", "wpjobboard") ?></span>
								</a>
								<input type="submit" value="" style="display: none"/>
							</div>
						
						</form>
					</div>
				</div>
				<div class="col-2">
					<div id="wpjb-top-fil" class="wpjb-layer-inside wpjb-filter-applications"
					     style="background: none; border: none; margin: .52rem">
						<button type="button" id="buttomFilter" class="btn btn-secondary">
							<span><?php _e("Filtrar", "wpjobboard") ?></span>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div v-if="message===false" class="wpjb-grid wpjb-grid-compact">
			
			<?php if (!empty($apps->application)): ?>
				
				<?php foreach ($apps->application as $application): ?>
					<?php $job = $application->getJob(true); ?>
					<?php $current_status = wpjb_get_application_status($application->status) ?>
					
					<div
							class="wpjb-grid-row wpjb-manage-item wpjb-manage-application wpjb-application-status-<?php echo esc_attr($current_status["key"]) ?>"
							data-id="<?php echo esc_html($application->id) ?>">
						
						<div class="wpjb-grid-col wpjb-col-1 wpjb-manage-header-img" style="width:60px">
							<?php echo get_avatar($application->email, 52) ?>
						</div>
						
						<div class="wpjb-grid-col wpjb-col-90" style="width:calc( 100% - 60px )">
							<div class="wpjb-manage-header">
                    
                    <span class="wpjb-manage-header-left wpjb-line-major wpjb-manage-title">
                        <a href="<?php echo esc_attr(add_query_arg($query_args, wpjb_link_to("job_application", $application))) ?>">
                            <?php if ($application->applicant_name): ?>
	                            <?php esc_html_e($application->applicant_name) ?>
                            <?php else: ?>
	                            <?php _e("ID");
	                            echo ": ";
	                            echo $application->id; ?>
                            <?php endif; ?>
                        </a>

                    </span>
								
								<ul class="wpjb-manage-header-right">
									
									<?php do_action("wpjb_sh_manage_applications_header_right_before", $application->id) ?>
									
									<li>
										<span class="wpjb-glyphs wpjb-icon-briefcase"></span>
										<span class="wpjb-manage-header-right-item-text">
                                <a href="<?php echo wpjb_link_to("job", $job) ?>"
                                   class="wpjb-no-text-decoration"><?php echo esc_html($job->job_title) ?></a>
                            </span>
									</li>
									
									<li>
										<span class="wpjb-glyphs wpjb-icon-clock"></span>
										<span class="wpjb-manage-header-right-item-text">
                            <?php echo esc_html(sprintf(__("%s ago.", "wpjobboard"), wpjb_time_ago($application->applied_at))) ?>
                            </span>
									</li>
									
									<?php do_action("wpjb_sh_manage_applications_header_right_after", $application->id) ?>
								</ul>
							
							
							</div>
							
							
							<div class="wpjb-manage-actions-wrap">

                    <span class="wpjb-manage-actions-left">
  

                        <a href="<?php echo esc_attr(add_query_arg($query_args, wpjb_link_to("job_application", $application))) ?>"
                           class="wpjb-manage-action wpjb-no-320-760"><span
			                        class="wpjb-glyphs wpjb-icon-eye"></span><?php _e("View", "wpjobboard") ?></a>

                        <a href="<?php echo wpjb_api_url("print/index"); ?>?id=<?php echo $application->id ?>"
                           target="_blank" class="wpjb-manage-action">
                            <span class="wpjb-glyphs wpjb-icon-print"></span>
                            <?php _e("Print", "wpjobboard") ?>
                        </a>
                        
                        <a href="<?php echo wpjb_link_to("application_delete", $application); ?>"
                           title="<?php _e("Delete", "wpjobboard") ?>"
                           class="wpjb-manage-action wpjb-manage-action-delete" data-id="<?php echo $application->id ?>"
                           data-nonce="<?php echo wp_create_nonce('wpjobboard-manage-delete') ?>">
                            <span class="wpjb-glyphs wpjb-icon-trash"></span>
                            <?php _e("Delete", "wpjobboard") ?>
                        </a>
                        
                        <a href="#" class="wpjb-manage-action wpjb-manage-app-status-change">
                            <span class="wpjb-glyphs wpjb-icon-down-open"></span>
                            <?php _e("Status", "wpjobboard") ?> —
                            <strong class="wpjb-application-status-current-label"><?php echo esc_html($current_status["label"]) ?></strong>
                        </a>
                        
                        <?php do_action("wpjb_sh_manage_applications_actions_left", $job->id, $job->post_id, $application) ?>
                    </span>
								<span class="wpjb-manage-actions-right">
                        
                        <?php $rated = absint($application->meta->rating->value()) ?>
                        <span class="wpjb-manage-action wpjb-star-ratings"
                              data-id="<?php echo esc_html($application->id) ?>">
                            <span class="wpjb-glyphs wpjb-icon-spinner wpjb-animate-spin wpjb-star-rating-loader"
                                  style="vertical-align: top; display:none"></span>
                            <span class="wpjb-star-rating-bar">
                                <?php for ($i = 0; $i < 5; $i++): ?><span
	                                class="wpjb-star-rating wpjb-motif wpjb-glyphs wpjb-icon-star-empty <?php if ($rated > $i): ?>wpjb-star-checked<?php endif; ?>"
	                                data-value="<?php echo $i + 1 ?>" ></span><?php endfor ?>
                            </span>
                        </span>
                        
                        <?php do_action("wpjb_sh_manage_applications_actions_right", $job->id, $job->post_id, $application) ?>

                        
                        <a href="#" class="wpjb-manage-action wpjb-manage-action-more"><span
			                        class="wpjb-glyphs wpjb-icon-menu"></span><?php _e("More", "wpjobboard") ?></a>
                    </span>
								
								<div class="wpjb-manage-actions-more">
									<?php do_action("wpjb_sh_manage_applications_actions_more", $job->id, $job->post_id, $application) ?>
								</div>
							</div>
						
						</div>
						
						<div style="clear: both; overflow: hidden"></div>
						
						<div class="wpjb-application-change-status wpjb-filter-applications" style="display: none">
							<select name="job_id" class="wpjb-application-change-status-dropdown">
								<?php foreach ($public_ids as $status_id): ?>
									<?php $status = wpjb_get_application_status($status_id) ?>
									<option
											value="<?php echo esc_html($status_id) ?>"
										<?php selected($application->status, $status_id) ?>
											data-can-notify="<?php if (isset($status["notify_applicant_email"]) && !empty($status["notify_applicant_email"])): ?>1<?php endif; ?>"
									><?php echo esc_html($status["label"]) ?>
									</option>
								<?php endforeach; ?>
							</select>
							
							<input type="checkbox" value="1" class="wpjb-application-change-status-checkbox"
							       id="wpjb-application-status-<?php echo $application->id ?>">
							<label class="wpjb-application-change-status-label"
							       for="wpjb-application-status-<?php echo $application->id ?>"><?php _e("Notify applicant via email", "wpjobboard") ?></label>
							
							<span class="wpjb-glyphs wpjb-icon-spinner wpjb-animate-spin wpjb-none wpjb-application-change-status-loader"></span>
							
							<a href="#" class="wpjb-button wpjb-application-change-status-submit"
							   style="float:right"><?php _e("Change", "wpjobboard") ?></a>
						</div>
						
						<?php do_action("wpjb_sh_manage_applications_after", $job->id, $job->post_id, $application) ?>
					</div>
				
				<?php endforeach; ?>
			<?php else: ?>
				<div class="wpjb-grid-row">
					<div class="wpjb-col-100 wpjb-grid-col-center">
						<?php _e("No applicants found.", "wpjobboard"); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<div class="wpjb-grid wpjb-grid-compact" v-else-if="typeof message === 'string'">
			<div class="wpjb-grid-row">
				<div class="wpjb-col-100 wpjb-grid-col-center">
					{{message}}
				</div>
			</div>
		</div>
		<?php if (!empty($apps->application)): ?>
			<div class="wpjb-paginate-links">
				<?php wpjb_paginate_links($url, $apps->pages, $apps->page) ?>
			</div>
		<?php endif; ?>
		<div class="container">
			<!-- Modal -->
			<div id="filterApplicants" class="modal" tabindex="-1" role="dialog" aria-labelledby="filterApplicants"
			     aria-hidden="true"
			     style="margin-top: 2rem;" ref="filterApplicants">
				<div class="modal-dialog modal-lg" role="document" style="max-width: 60% !important;">
					<div class="modal-content">
						<div class="modal-body">
							<div class="container">
								<div class="row">
									<div class="col">
										<h5 class="modal-title"><?php _e("Filtros", "wpjobboard"); ?></h5>
									</div>
									<div class="col">
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
								</div>
								<form v-if="!searchEnable">
									<div class="row">
										<div class="col-6">
											<div class="container">
												<div class="form-group">
													<label for="job"><?php _e("Avisos.", "wpjobboard"); ?>
													</label>
													<select class="form-control w-100" id="job" v-model="jobs">
														<option disabled
														        selected><?php _e("Seleccioanr Aviso.", "wpjobboard"); ?></option>
														<?php foreach ($jobsList as $job): ?>
															<option value="<?php echo esc_html($job->id) ?>" <?php selected($job->id, $job_id) ?>><?php echo esc_html($job->job_title) ?></option>
														<?php endforeach; ?>
													</select>
												</div>
												<div class="form-group">
													<label class="w-100">
														<input type="text"
														       class="form-control"
														       v-model="keyPhrase"
														       placeholder="<?php _e("Palabra clave o frase.", "wpjobboard"); ?>">
													</label>
												</div>
												<div class="form-group">
													<label><?php _e("Lugar de Residencia", "wpjobboard"); ?></label>
													<label class="w-100">
														<input type="text"
														       class="form-control"
														       v-model="residence"
														       placeholder="<?php _e("Provincia/Estado.", "wpjobboard"); ?>">
													</label>
													<label class="w-100">
														<input type="text"
														       class="form-control"
														       v-model="city"
														       placeholder="<?php _e("Ciudad.", "wpjobboard"); ?>">
													</label>
												</div>
												<div class="form-group">
													<label><?php _e("Datos Personales", "wpjobboard"); ?></label>
													<label class="w-100">
														<input type="text"
														       class="form-control"
														       v-model="name"
														       placeholder="<?php _e("Nombres.", "wpjobboard"); ?>">
													</label>
													<label class="w-100">
														<input type="text"
														       class="form-control"
														       v-model="lastName"
														       placeholder="<?php _e("Apellidos.", "wpjobboard"); ?>">
													</label>
													<label class="w-100">
														<input type="email"
														       class="form-control"
														       v-model="email"
														       placeholder="<?php _e("E-mail.", "wpjobboard"); ?>">
													</label>
												</div>
											</div>
										</div>
										<div class="col-6">
											<div class="form-group">
												<label><?php _e("Tipo de Discapacidad", "wpjobboard"); ?></label>
												<div class="container">
													<div class="row">
														<div class="col m-3">
															<div class="form-group">
																<input
																		class="form-check-input"
																		type="checkbox" value="Motriz"
																		id="defaultCheck1" v-model="motriz">
																<label for="defaultCheck1"><?php _e("Motriz", "wpjobboard"); ?></label>
															</div>
															<div class="form-group">
																<input
																		class="form-check-input" type="checkbox"
																		v-model="auditive"
																		value="Auditiva"
																		id="defaultCheck2">
																<label for="defaultCheck2"><?php _e("Auditiva", "wpjobboard"); ?></label>
															</div>
															<div class="form-group">
																<input class="form-check-input"
																       type="checkbox" value="Visual"
																       v-model="visual"
																       id="defaultCheck3">
																<label for="defaultCheck3"><?php _e("Visual", "wpjobboard"); ?></label>
															</div>
															<div class="form-group">
																<input
																		class="form-check-input" type="checkbox"
																		value="Visceral"
																		v-model="visceral"
																		id="defaultCheck4">
																<label for="defaultCheck4"><?php _e("Visceral", "wpjobboard"); ?></label>
															</div>
														</div>
														<div class="col m-3">
															<div class="form-group">
																<input class="form-check-input"
																       type="checkbox" value="Intelectual"
																       v-model="intelectual"
																       id="defaultCheck5">
																<label for="defaultCheck5"><?php _e("Intelectual", "wpjobboard"); ?>
																</label>
															</div>
															<div class="form-group">
																<input class="form-check-input"
																       type="checkbox" value="Psiquica"
																       v-model="psiquica"
																       id="defaultCheck6">
																<label for="defaultCheck6"><?php _e("Psiquica", "wpjobboard"); ?></label>
															</div>
															<div class="form-group">
																<input class="form-check-input"
																       type="checkbox" value="habla"
																       id="defaultCheck7">
																<label for="defaultCheck7"><?php _e("Habla", "wpjobboard"); ?></label>
															</div>
															<div class="form-group">
																<input class="form-check-input"
																       type="checkbox" value="Ninguna"
																       v-model="ninguna"
																       id="defaultCheck8">
																<label for="defaultCheck8"><?php _e("Ninguna", "wpjobboard"); ?></label>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label><?php _e("Educación", "wpjobboard"); ?></label>
												<label class="w-100">
													<input type="text"
													       class="form-control"
													       v-model="education"
													       placeholder="<?php _e("Instituto/Colegio/Universidad.", "wpjobboard"); ?>">
												</label>
												<label class="w-100">
													<input type="text"
													       class="form-control"
													       v-model="course"
													       placeholder="<?php _e("Carrera/Curso.", "wpjobboard"); ?>">
												</label>
												<label class="w-100">
													<input type="text"
													       class="form-control"
													       v-model="description"
													       placeholder="<?php _e("Descripción", "wpjobboard"); ?>">
												</label>
											</div>
											<div class="form-group">
												<label for="idioms"><?php _e("Idiomas.", "wpjobboard"); ?>
												</label>
												<select class="form-control w-100" id="idioms" v-model="idioms">
													<option disabled
													        selected><?php _e("Elegir Idioma.", "wpjobboard"); ?></option>
													<option value="idioma_ingles">Inglés</option>
													<option value="idioma_protugues">Portugues</option>
													<option value="idioma_frances">Frances</option>
													<option value="idioma_aleman">Alemán</option>
												</select>
												<div class="mt-1">
													<div class="row">
														<div class="col">
															<label for="oral"><?php _e("Nivel Oral.", "wpjobboard"); ?>
															</label>
															<select class="form-control w-100" id="oral" v-model="oral">
																<option disabled
																        selected><?php _e("Elegir Nivel.", "wpjobboard"); ?></option>
																<option>Básico</option>
																<option>Intermedio</option>
																<option>Avanzado</option>
																<option>Bilingüe</option>
															</select>
														</div>
														<div class="col">
															<label for="escrito"><?php _e("Nivel Escrito.", "wpjobboard"); ?>
															</label>
															<select class="form-control w-100" id="escrito"
															        v-model="letter">
																<option disabled
																        selected><?php _e("Elegir Nivel.", "wpjobboard"); ?></option>
																<option>Básico</option>
																<option>Intermedio</option>
																<option>Avanzado</option>
																<option>Bilingüe</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<hr class="w-100">
									<div class="row">
										<div class="col">
											<div class="form-check form-check-inline">
												<label class="form-check-label"
												       for="inlineCheckbox1"><?php _e("Etiquetas:", "wpjobboard"); ?></label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" id="inlineCheckbox1"
												       value="Leído" v-model="leido">
												<label class="form-check-label"
												       for="inlineCheckbox1"
												       style="color: black"><?php _e("#Leído", "wpjobboard"); ?></label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" id="inlineCheckbox2"
												       value="Seleccionado"
												       v-model="seleccionado">
												<label class="form-check-label"
												       for="inlineCheckbox2"
												       style="color: green"><?php _e("#Seleccionado", "wpjobboard"); ?></label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" id="inlineCheckbox2"
												       value="Preseleccionado" v-model="preseleccionado">
												<label class="form-check-label"
												       for="inlineCheckbox2"
												       style="color: orange"> <?php _e("#Preseleccionado", "wpjobboard"); ?></label>
											</div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" id="inlineCheckbox2"
												       value="Desestimado" v-model="desestimado">
												<label class="form-check-label"
												       for="inlineCheckbox2"
												       style="color: red"><?php _e("#Desestimado", "wpjobboard"); ?></label>
											</div>
										</div>
									</div>
								</form>
								<div v-else class="container" style="word-wrap: break-word;">
									<p>{{message}}</p>
								</div>
							</div>
						</div>
						<div class="modal-footer" v-if="!searchEnable">
							<div class="container text-center">
								<button
										v-on:click="filterData(<?php echo esc_html(get_current_user_id() . ',"' . plugins_url() . '"'); ?>)"
										type="button"
										class="btn btn-lg
						                                                                           btn-secondary"><?php _e("Buscar", "wpjobboard"); ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script type="text/javascript">
        jQuery(function ($) {
            $(document).ready(function () {
                $('#buttomFilter').click(function () {
                    $('#filterApplicants').appendTo("body").modal('toggle').modal('show');
                });
            });
        });
	</script>

<?php
$js = plugins_url() . '/incluyeme/include/assets/js/';
$css = plugins_url() . '/incluyeme/include/assets/css/';
wp_register_script('bootstrapJs', $js . 'bootstrap.min.js', ['jquery']);
wp_register_script('vueJS', $js . 'vueDEV.js', ['bootstrapJs']);
wp_register_script('vueApp', $js . 'vueApp.js', ['vueJS']);
wp_register_style('bootstrap-css', $css . 'bootstrap.min.css', ['wpjb-css']);
wp_enqueue_script('bootstrapJs');
wp_enqueue_script('vueJS');
wp_enqueue_script('vueApp');
wp_enqueue_style('bootstrap-css');
?>