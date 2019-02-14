<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0451ce15c75f710edca682cf2e49d9de
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PleistermanWpAdminGenerator\\Common\\' => 35,
            'PleistermanWpAdminGenerator\\Admin\\' => 34,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PleistermanWpAdminGenerator\\Common\\' => 
        array (
            0 => __DIR__ . '/../..' . '/common/inc',
        ),
        'PleistermanWpAdminGenerator\\Admin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/admin/inc',
        ),
    );

    public static $classMap = array (
        'PleistermanWpAdminGenerator\\Admin\\Authorisation' => __DIR__ . '/../..' . '/admin/inc/Authorisation.php',
        'PleistermanWpAdminGenerator\\Admin\\Base\\CommonClass' => __DIR__ . '/../..' . '/admin/inc/Base/CommonClass.php',
        'PleistermanWpAdminGenerator\\Admin\\DeInstaller' => __DIR__ . '/../..' . '/admin/inc/DeInstaller.php',
        'PleistermanWpAdminGenerator\\Admin\\Fields' => __DIR__ . '/../..' . '/admin/inc/Fields.php',
        'PleistermanWpAdminGenerator\\Admin\\HtmlGenerators\\DropdownGenerators\\DefaultDropdownGenerator' => __DIR__ . '/../..' . '/admin/inc/html-generators/dropdown-generators/DefaultDropdownGenerator.php',
        'PleistermanWpAdminGenerator\\Admin\\HtmlGenerators\\DropdownGenerators\\DivDropdownGenerator' => __DIR__ . '/../..' . '/admin/inc/html-generators/dropdown-generators/DivDropdownGenerator.php',
        'PleistermanWpAdminGenerator\\Admin\\HtmlGenerators\\DropdownGenerators\\DropdownGenerator' => __DIR__ . '/../..' . '/admin/inc/html-generators/dropdown-generators/DropdownGenerator.php',
        'PleistermanWpAdminGenerator\\Admin\\HtmlGenerators\\ElementGenerator' => __DIR__ . '/../..' . '/admin/inc/html-generators/ElementGenerator.php',
        'PleistermanWpAdminGenerator\\Admin\\HtmlGenerators\\FieldGenerators\\FieldGenerator' => __DIR__ . '/../..' . '/admin/inc/html-generators/field-generators/FieldGenerator.php',
        'PleistermanWpAdminGenerator\\Admin\\HtmlGenerators\\FieldGenerators\\RadioGroupGenerator' => __DIR__ . '/../..' . '/admin/inc/html-generators/field-generators/RadioGroupGenerator.php',
        'PleistermanWpAdminGenerator\\Admin\\HtmlGenerators\\FormGenerator' => __DIR__ . '/../..' . '/admin/inc/html-generators/FormGenerator.php',
        'PleistermanWpAdminGenerator\\Admin\\HtmlGenerators\\HtmlGenerator' => __DIR__ . '/../..' . '/admin/inc/html-generators/HtmlGenerator.php',
        'PleistermanWpAdminGenerator\\Admin\\HtmlGenerators\\TabsGenerator' => __DIR__ . '/../..' . '/admin/inc/html-generators/TabsGenerator.php',
        'PleistermanWpAdminGenerator\\Admin\\HtmlGenerators\\TitleGenerator' => __DIR__ . '/../..' . '/admin/inc/html-generators/TitleGenerator.php',
        'PleistermanWpAdminGenerator\\Admin\\Lists' => __DIR__ . '/../..' . '/admin/inc/Lists.php',
        'PleistermanWpAdminGenerator\\Admin\\Main' => __DIR__ . '/../..' . '/admin/inc/Main.php',
        'PleistermanWpAdminGenerator\\Admin\\Menu' => __DIR__ . '/../..' . '/admin/inc/Menu.php',
        'PleistermanWpAdminGenerator\\Admin\\Page' => __DIR__ . '/../..' . '/admin/inc/Page.php',
        'PleistermanWpAdminGenerator\\Admin\\Request' => __DIR__ . '/../..' . '/admin/inc/Request.php',
        'PleistermanWpAdminGenerator\\Admin\\Sanitizers\\SanitizeEmail' => __DIR__ . '/../..' . '/admin/inc/sanitizers/SanitizeEmail.php',
        'PleistermanWpAdminGenerator\\Admin\\Sanitizers\\Sanitizer' => __DIR__ . '/../..' . '/admin/inc/sanitizers/Sanitizer.php',
        'PleistermanWpAdminGenerator\\Admin\\ScriptLoader' => __DIR__ . '/../..' . '/admin/inc/ScriptLoader.php',
        'PleistermanWpAdminGenerator\\Admin\\Sections' => __DIR__ . '/../..' . '/admin/inc/Sections.php',
        'PleistermanWpAdminGenerator\\Admin\\StyleSheetLoader' => __DIR__ . '/../..' . '/admin/inc/StyleSheetLoader.php',
        'PleistermanWpAdminGenerator\\Admin\\Tabs' => __DIR__ . '/../..' . '/admin/inc/Tabs.php',
        'PleistermanWpAdminGenerator\\Admin\\Translations' => __DIR__ . '/../..' . '/admin/inc/Translations.php',
        'PleistermanWpAdminGenerator\\Admin\\Validators\\Validator' => __DIR__ . '/../..' . '/admin/inc/validators/Validator.php',
        'PleistermanWpAdminGenerator\\Common\\Common' => __DIR__ . '/../..' . '/common/inc/Common.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0451ce15c75f710edca682cf2e49d9de::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0451ce15c75f710edca682cf2e49d9de::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0451ce15c75f710edca682cf2e49d9de::$classMap;

        }, null, ClassLoader::class);
    }
}
