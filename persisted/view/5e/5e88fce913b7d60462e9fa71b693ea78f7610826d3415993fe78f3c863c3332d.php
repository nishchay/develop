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

/* /Users/bpatel/learn/NSH-App/Application/views/namaste.twig */
class __TwigTemplate_2d417537a3637f2635bd6fcf956e888540b90b75ed34ab243df1ab4bd6affb0c extends Template
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
        <title>Nishchay - Open structure PHP framework</title>
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
            .descr-content h6{font-weight: bold}
            .equal-divide .row {display: flex;display: -webkit-box;display: -webkit-flex;display: -ms-flexbox;display: flex;-webkit-box-pack: justify;-webkit-justify-content: space-between;-ms-flex-pack: justify;justify-content: space-between;}
            .equal-divide .col-sm-3{border-left:1px dashed #333}
            .equal-divide .col-sm-3:first-child{border:0}
            .skp-cool h5{text-align: center;font-weight: bold;margin-top: 5px}
            .skp-cool .col-sm-2{height: 150px;box-shadow:0 0 3px #CCC;border-radius:3px;font-size: 14px}
            .skp-cool .col-sm-2 div{text-align: justify}
            .skp-cool .bg-red{background-color: #f8085b;color: #FFF}
            .skp-cool .border-red{border: 1px solid #f8085b;color: #f8085b}
            .skp-cool .bg-blue{background-color: #439dff;color: #FFF}
            .skp-cool .border-blue{border: 1px solid #439dff;color: #439dff}
            .footer {background-color: #FFF;margin-top: 20px;bottom: 0;width: 100%;padding: 10px;box-sizing: border-box;border-top: 1px solid #439dff;box-shadow: 1px 1px 3px #439dff;}
            .footer h5{text-align: center;color: #439dff}
        </style>
    </head>
    <body>
        <div class=\"container-fluid wrapper\">
            <div class=\"row text-center header\">
                <div class=\"col-lg-12\">
                    <a href=\"";
        // line 43
        echo ($context["nishchayUrl"] ?? null);
        echo "\" target=\"blank\"><img src=\"";
        echo call_user_func_array($this->env->getFunction('getResourceURL')->getCallable(), ["images/Nishchay.png"]);
        echo "\" alt=\"Nishchay Logo\"/></a>
                </div>
            </div>
            <div class=\"row descr-box\">
                <div class=\"col-lg-1\"></div>
                <div class=\"col-lg-10\">
                    <div class=\"descr-content\">
                        <p>
                            Namaste(Hello) ";
        // line 51
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo ",
                        </p>
                        <div class=\"equal-divide\">
                            <div class=\"row\">
                                <div class=\"col-sm-3\">
                                    <h6>Beginner? Follow first step</h6>
                                    <ol>
                                        <li>Use structure came with installation or create your <a href=\"";
        // line 58
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/learningCenter/openStructure"), "html", null, true);
        echo "\" target=\"blank\">own</a>.</li>
                                        <li>Create your first <a href=\"";
        // line 59
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/learningCenter/request/requestHandling"), "html", null, true);
        echo "\" target=\"blank\">Route</a> which will handle your request.</li>
                                        <li>Create <a href=\"";
        // line 60
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/learningCenter/request/responseHandling"), "html", null, true);
        echo "\" target=\"blank\">View</a> for your route response.</li>
                                        <li>That's it. You completed your first step.</li>
                                    </ol>
                                </div>
                                <div class=\"col-sm-3\">
                                    <h6>Enable Application to handle Data</h6>
                                    <ol>
                                        <li>Edit your database <a href=\"";
        // line 67
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/learningCenter/settings/database"), "html", null, true);
        echo "\" target=\"blank\">Setting File</a>.</li>
                                        <li>Use <a href=\"";
        // line 68
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/learningCenter/consoleCommand"), "html", null, true);
        echo "\" target=\"blank\">Console command</a> to generate entities from template.</li>
                                        <li>Learn more about <a href=\"";
        // line 69
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/learningCenter/data/entity"), "html", null, true);
        echo "\" target=\"blank\">Data Management</a>.</li>
                                        <li>Take a guidelines or use existing code from <a href=\"";
        // line 70
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/learningCenter/codes"), "html", null, true);
        echo "\" target=\"blank\">here</a>.</li>
                                    </ol>
                                </div>
                                <div class=\"col-sm-3\">
                                    <h6>Learn more</h6>
                                    <ol>
                                        <li>Follow <a href=\"";
        // line 76
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/learn/guide/coding"), "html", null, true);
        echo "\" target=\"blank\">Coding Standards</a> to keep the code clean and undestandble to everyone.</li>
                                        <li>Learn more about application setting <a href=\"";
        // line 77
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/learningCenter/settings/application"), "html", null, true);
        echo "\" target=\"blank\">here</a>.</li>
                                        <li>Learn more about <a href=\"";
        // line 78
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/learningCenter/guide/security"), "html", null, true);
        echo "\" target=\"blank\">Security Consideration</a> for application.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"col-lg-1\"></div>
            </div>
            <h3>Keep track of your learning progress by registering to <a href=\"";
        // line 87
        echo twig_escape_filter($this->env, (($context["nishchayUrl"] ?? null) . "/register"), "html", null, true);
        echo "\">Nishchay</a>.</h3>
            <div class=\"row\">
                <div class=\"col-lg-1\"></div>
                <div class=\"col-lg-10\">
                    <div class=\"equal-divide skp-cool\">
                        <div class=\"row\">
                            <div class=\"col-sm-2 bg-red\">
                                <h5>Open Structure</h5>
                                <div>
                                    Create your own structure to suits your need.
                                    Any update to Nishchay system will never affect structure.
                                </div>
                            </div>
                            <div class=\"col-sm-2 border-red\">
                                <h5>Web Service</h5>
                                <div>
                                    Develop web service which allows you define open or secure service.
                                    This also allows filter responnse based on request.
                                </div>
                            </div>
                            <div class=\"col-sm-2 border-blue\">
                                <h5>Sessions</h5>
                                <div>
                                    Use various kind of session. 
                                    Each session type has their own speciality.
                                    Session data be stored in file, DB or memcache.
                                </div>
                            </div>
                            <div class=\"col-sm-2 bg-blue\">
                                <h5>& more</h5>
                                <div>
                                    Entity Manager, Console Commands, Maintenance modes, Application Stages, Dependency Injection and many more.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=\"col-lg-1\"></div>
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
        return "/Users/bpatel/learn/NSH-App/Application/views/namaste.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  172 => 87,  160 => 78,  156 => 77,  152 => 76,  143 => 70,  139 => 69,  135 => 68,  131 => 67,  121 => 60,  117 => 59,  113 => 58,  103 => 51,  90 => 43,  59 => 15,  50 => 9,  45 => 7,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "/Users/bpatel/learn/NSH-App/Application/views/namaste.twig", "/Users/bpatel/learn/NSH-App/Application/views/namaste.twig");
    }
}
