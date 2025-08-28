<?php
    use Illuminate\Support\Facades\Log;

    $checkSequenceContent = $file->checkSequenceContent();
    $sequenceContentHasError = (!empty($checkSequenceContent) && (!empty($checkSequenceContent['all_passed_items_error']) || !empty($checkSequenceContent['access_after_day_error'])));
    $securitySettings = getGeneralSecuritySettings();
    $shouldRedirectToMobileApp = session('error') && !empty($securitySettings['device_restriction']) && $securitySettings['device_restriction'] == "1";

    // Logging relevant information
    Log::info('Sequence Content Check', [
        'checkSequenceContent' => $checkSequenceContent,
        'sequenceContentHasError' => $sequenceContentHasError,
        'securitySettings' => $securitySettings,
        'shouldRedirectToMobileApp' => $shouldRedirectToMobileApp,
    ]);
?>


<div class="accordion-row rounded-sm border mt-15 p-15 bg-white">
    <div class="d-flex align-items-center justify-content-between" role="tab" id="files_<?php echo e($file->id); ?>">
        <div class="d-flex align-items-center" href="#collapseFiles<?php echo e($file->id); ?>" aria-controls="collapseFiles<?php echo e($file->id); ?>" data-parent="#<?php echo e($accordionParent); ?>" role="button" data-toggle="collapse" aria-expanded="true">
            <span class="d-flex align-items-center justify-content-center mr-15">
                <span class="chapter-icon chapter-content-icon">
                    <i data-feather="<?php echo e($file->getIconByType()); ?>" width="20" height="20" class="text-gray"></i>
                </span>
            </span>
            <span class="font-weight-bold text-secondary font-14 file-title"><?php echo e($file->title); ?></span>
        </div>
        <i class="collapse-chevron-icon" data-feather="chevron-down" height="20" href="#collapseFiles<?php echo e(!empty($file) ? $file->id : 'record'); ?>" aria-controls="collapseFiles<?php echo e(!empty($file) ? $file->id : 'record'); ?>" data-parent="#<?php echo e($accordionParent); ?>" role="button" data-toggle="collapse" aria-expanded="true"></i>
    </div>

    <div id="collapseFiles<?php echo e($file->id); ?>" aria-labelledby="files_<?php echo e($file->id); ?>" class="collapse" role="tabpanel">
        <div class="panel-collapse">
            <div class="text-gray text-14">
                <?php echo nl2br(clean($file->description)); ?>

            </div>

            <?php if(!empty($user) && $hasBought): ?>
                <div class="d-flex align-items-center mt-20">
                    <label class="mb-0 mr-10 cursor-pointer font-weight-500" for="fileReadToggle<?php echo e($file->id); ?>"><?php echo e(trans('public.i_passed_this_lesson')); ?></label>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" <?php if($sequenceContentHasError): ?> disabled <?php endif; ?> id="fileReadToggle<?php echo e($file->id); ?>" data-file-id="<?php echo e($file->id); ?>" value="<?php echo e($course->id); ?>" class="js-file-learning-toggle custom-control-input" <?php if(!empty($file->checkPassedItem())): ?> checked <?php endif; ?>>
                        <label class="custom-control-label" for="fileReadToggle<?php echo e($file->id); ?>"></label>
                    </div>
                </div>
            <?php endif; ?>

            <div class="d-flex align-items-center justify-content-between mt-20">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center text-gray text-center font-14 mr-20">
                        <i data-feather="download-cloud" width="18" height="18" class="text-gray mr-5"></i>
                        <span class="line-height-1"><?php echo e(($file->volume > 0) ? $file->getVolume() : '-'); ?></span>
                    </div>
                </div>

                <div>
                    <?php if(!empty($checkSequenceContent) && $sequenceContentHasError): ?>
                        <button type="button" class="course-content-btns btn btn-sm btn-gray flex-grow-1 disabled js-sequence-content-error-modal"
                                data-passed-error="<?php echo e(!empty($checkSequenceContent['all_passed_items_error']) ? $checkSequenceContent['all_passed_items_error'] : ''); ?>"
                                data-access-days-error="<?php echo e(!empty($checkSequenceContent['access_after_day_error']) ? $checkSequenceContent['access_after_day_error'] : ''); ?>">
                            <?php echo e(trans('public.play')); ?>

                        </button>
                    <?php elseif($file->accessibility == 'paid'): ?>
                        <?php if(!empty($user) && $hasBought): ?>
                            <?php if($file->downloadable): ?>
                                <a href="<?php echo e($shouldRedirectToMobileApp ? '/mobile-app' : $course->getUrl() . '/file/' . $file->id . '/download'); ?>" 
                                   class="course-content-btns btn btn-sm btn-primary" 
                                   target="<?php echo e($shouldRedirectToMobileApp ? '_self' : '_blank'); ?>">
                                    <?php echo e(trans('home.download')); ?>

                                </a>
                            <?php else: ?>
                                <a href="<?php echo e($shouldRedirectToMobileApp ? '/mobile-app' : $course->getLearningPageUrl() . '?type=file&item=' . $file->id); ?>" 
                                   target="<?php echo e($shouldRedirectToMobileApp ? '_self' : '_blank'); ?>" 
                                   class="course-content-btns btn btn-sm btn-primary">
                                    <?php echo e(trans('public.play')); ?>

                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <button type="button" class="course-content-btns btn btn-sm btn-gray disabled <?php echo e(empty($user) ? 'not-login-toast' : (!$hasBought ? 'not-access-toast' : '')); ?>">
                                <?php echo e($file->downloadable ? trans('home.download') : trans('public.play')); ?>

                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if($file->downloadable): ?>
                            <a href="<?php echo e($shouldRedirectToMobileApp ? '/mobile-app' : $course->getUrl() . '/file/' . $file->id . '/download'); ?>" 
                               class="course-content-btns btn btn-sm btn-primary" 
                               target="<?php echo e($shouldRedirectToMobileApp ? '_self' : '_blank'); ?>">
                                <?php echo e(trans('home.download')); ?>

                            </a>
                        <?php else: ?>
                            <?php if(!empty($user) && $hasBought): ?>
                                <a href="<?php echo e($shouldRedirectToMobileApp ? '/mobile-app' : $course->getLearningPageUrl() . '?type=file&item=' . $file->id); ?>" 
                                   target="<?php echo e($shouldRedirectToMobileApp ? '_self' : '_blank'); ?>" 
                                   class="course-content-btns btn btn-sm btn-primary">
                                    <?php echo e(trans('public.play')); ?>

                                </a>
                            <?php elseif($file->storage == 'upload_archive'): ?>
                                <a href="/course/<?php echo e($course->slug); ?>/file/<?php echo e($file->id); ?>/showHtml" 
                                   target="<?php echo e($shouldRedirectToMobileApp ? '_self' : '_blank'); ?>" 
                                   class="course-content-btns btn btn-sm btn-primary">
                                    <?php echo e(trans('public.play')); ?>

                                </a>
                            <?php elseif(in_array($file->storage, ['iframe', 'google_drive', 'dropbox'])): ?>
                                <a href="/course/<?php echo e($course->slug); ?>/file/<?php echo e($file->id); ?>/play" 
                                   target="<?php echo e($shouldRedirectToMobileApp ? '_self' : '_blank'); ?>" 
                                   class="course-content-btns btn btn-sm btn-primary">
                                    <?php echo e(trans('public.play')); ?>

                                </a>
                            <?php elseif($file->isVideo()): ?>
                                <button type="button" data-id="<?php echo e($file->id); ?>" data-title="<?php echo e($file->title); ?>" class="js-play-video course-content-btns btn btn-sm btn-primary">
                                    <?php echo e(trans('public.play')); ?> 
                                </button>
                  
                            <?php else: ?>
                                <a href="<?php echo e($file->file); ?>" 
                                   target="<?php echo e($shouldRedirectToMobileApp ? '_self' : '_blank'); ?>" 
                                   class="course-content-btns btn btn-sm btn-primary">
                                    <?php echo e(trans('public.play')); ?>

                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/codinger/htdocs/codinger.online/resources/views/web/default/course/tabs/contents/files.blade.php ENDPATH**/ ?>