<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DirectiveServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('mInput', function($expression) {
            return "<?php 
                if({$expression}['type'] == \"hidden\")
                    echo '<input type=\"hidden\" value=\"'.{$expression}['value'].'\">';
                else
                    echo '<div class=\"form-group m-form__group\">
                        <label for=\"'.(isset({$expression}['name']) ? {$expression}['name'] : '').'_input\">
                            '.(isset({$expression}['label']) ? {$expression}['label'] : '').'
                        </label>
                        <input 
                        type=\"'.{$expression}['type'].'\" 
                        class=\"form-control m-input m-input--air\" 
                        id=\"'.(isset({$expression}['name']) ? {$expression}['name'] : '').'_input\" 
                        name=\"'.(isset({$expression}['name']) ? {$expression}['name'] : '').'\" 
                        placeholder=\"'.(isset({$expression}['placeholder']) ? {$expression}['placeholder'] : '').'\"
                        value=\"'.(isset({$expression}['value']) ? {$expression}['value'] : '').'\">
                    </div>';
            ?>";
        });

        Blade::directive('mSelect2', function ($expression) {
            return "<?php 
                echo '<div class=\"form-group m-form__group\">
                <label for=\"'.{$expression}['name'].'_input\">
                    '.{$expression}['label'].'
                </label>
                <div class=\"m-select2 m-select2--air\">
                    <select class=\"form-control m-select2\" id=\"'.{$expression}['name'].'_input\" name=\"'.{$expression}['name'].'\" data-placeholder=\"'.{$expression}['placeholder'].'\">
                        <option value=\"'.(isset({$expression}['value']) ? {$expression}['value'] : '').'\">'.(isset({$expression}['text']) ? {$expression}['text'] : '').'</option>
                    </select>
                </div>
            </div>';
            ?>";
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}