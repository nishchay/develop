<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* /usr/local/var/www/nishchay-develop/Application/views/namaste.twig */
class __TwigTemplate_976623ddc605790155116519a9925ee62ff8e401b31d6954ecc1d41ddf3350f2 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <link rel=\"icon\" type=\"image/png\" href=\"";
        // line 7
        echo call_user_func_array($this->env->getFunction('getResourceURL')->getCallable(), ["images/favicon.png"]);
        echo "\" />
        <title>Nishchay framework - Developer build</title>
        <link type=\"text/css\" rel=\"stylesheet\" href=\"";
        // line 9
        echo call_user_func_array($this->env->getFunction('getResourceURL')->getCallable(), ["css/bootstrap.min.css"]);
        echo "\"/>
        <style type=\"text/css\">
            @font-face {
                font-family: 'Hind';
                font-style: normal;
                font-weight: 300;
                src: local('Hind Light'), local('Hind-Light'), url(\"";
        // line 15
        echo call_user_func_array($this->env->getFunction('getResourceURL')->getCallable(), ["fonts/google-hind.woff2"]);
        echo "\") format('woff2');
            }
            body{margin: 0;padding: 0;background-color: #fff;font-family: 'Hind', sans-serif;font-size: 15px}
            h3{text-align: center;margin: 30px 0}
            a{color: #f8085b;text-decoration: none}
            a:hover{color: #439dff;text-decoration: none}
            .header{padding: 10px 0;box-shadow:0 0 3px #f8085b;text-align: center}
            .header img{width: 150px}
            .descr-box{margin: 30px 0}
            .footer {background-color: #FFF;margin-top: 20px;bottom: 0;width: 100%;padding: 10px;box-sizing: border-box;border-top: 1px solid #439dff;box-shadow: 1px 1px 3px #439dff;}
            .footer h5{text-align: center;color: #439dff}
            h6{font-weight:bold}
            h1 {
                margin-top: 30px;
                text-align: center;
                background: linear-gradient(to right, #f8085b 36%, #00bdf5 55%);
                    background-clip: border-box;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
        </style>
    </head>
    <body>
        <div class=\"container-fluid wrapper\">
            <div class=\"row text-center header\">
                <div class=\"col-lg-12\">
                    <a href=\"";
        // line 41
        echo ($context["nishchayUrl"] ?? null);
        echo "\" target=\"_blank\"><img src=\"";
        echo call_user_func_array($this->env->getFunction('getResourceURL')->getCallable(), ["images/Nishchay.png"]);
        echo "\" alt=\"Nishchay Logo\"/></a>
                </div>
            </div>
            <div class=\"row descr-box\">
                <div class=\"col-lg-1\"></div>
                <div class=\"col-lg-10\">
                    <div class=\"descr-content\">
                        <p>
                            Namaste ";
        // line 49
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo ",
                        </p>
                        <p>
                            This is developer build which points to develop branch of framework. This build must be used for contribution only.
                        </p>
                        <h6>Set up things and get ready</h6>

                        <ul>
                            <li>To set up environment, Follow <a href=\"";
        // line 57
        echo ($context["nishchayUrl"] ?? null);
        echo "/contribute/code?ref=developerBuild\">this</a></li>
                            <li>Make sure you have read coding standard guidelines</li>
                        </ul>

                        <h6>Let's change or add things</h6>
                        <ul>
                            <li>You can either add new things. To add new thing create branch from upcoming release version branch.</li>
                            <li>To fix or improve things which should not bring new changes to framework, create branch from develop.</li>
                            <li>This build comes with unit test cases for the framework which is still in development, You can contribute to unit test cases.</li>
                            <li>If you have decided one of things from above, then first check if someone is already developing or not</li>
                        </ul>
                        <h1>You are free, you can contrbute anything you want</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class=\"footer fixed-bottom\" id=\"footer\">
            <h5>We only need one Nishchay(Decision)</h5>
        </div>
    </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "/usr/local/var/www/nishchay-develop/Application/views/namaste.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  112 => 57,  101 => 49,  88 => 41,  59 => 15,  50 => 9,  45 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/usr/local/var/www/nishchay-develop/Application/views/namaste.twig", "/usr/local/var/www/nishchay-develop/Application/views/namaste.twig");
    }
}
