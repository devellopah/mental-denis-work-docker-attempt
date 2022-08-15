@extends('layouts.app')
@section('content')
    @include('forms.create_group');
@endsection

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