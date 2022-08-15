<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('forms.create_group', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
<?php $__env->stopSection(); ?>

<script>
    window.addEventListener('load', function() {
        $.ajax({
            type: "GET",
            url: '/teacher/create_group_params',
            success: function (response) {
                handleSuccess(response);
            },
            dataType: 'json'
        });

        function handleSuccess(response) {
            $groupContainer = $('#groupContainer');

            $levels = response.levels;
            $themes = response.themes;

            
    
            $themeSelect = $groupContainer.find('[name="theme"]');

            $themeSelect.append(
                Object.keys($themes)
                    .map(function(el, i) {
                        return '<option value="' + el + '">' + el + '</option>';
                    })
                    .join('')
            );
    
            activeTheme = 'Уровень 1';
    
            $themeLevels = $levels[activeTheme].map(function(el, i) {
                return '<option value="' + el + '">' + el + '</option>';
            }).join('');
        
            replaceLevelOptions($themeLevels);
    
            $themeSelect.on('change', function(e) {
                $themeLevels = $levels[e.target.value].map(function (el, i) {
                    return '<option value="' + el + '">' + el + '</option>';
                }).join('');
    
                replaceLevelOptions($themeLevels);
            });
    
            function replaceLevelOptions($options) {
                $groupContainer.find('[name="level"]').empty().append($options);
            }
            
        }
    });
</script>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>