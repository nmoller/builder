<?php

/* forms/component.html */
class __TwigTemplate_b2a733e7c9f7332a8d358a27419500c961e5f2b73e873ac641e57beaf8d44bf1 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<input id=\"checkbox12\" type=\"checkbox\" value=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["comp"]) ? $context["comp"] : null), "name", array()), "html", null, true);
        echo "|";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["comp"]) ? $context["comp"] : null), "autre", array()), "html", null, true);
        echo "\" name=\"";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["comp"]) ? $context["comp"] : null), "name", array()), "html", null, true);
        echo "\"><label for=\"checkbox12\">";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["comp"]) ? $context["comp"] : null), "autre", array()), "html", null, true);
        echo "</label>";
    }

    public function getTemplateName()
    {
        return "forms/component.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("<input id=\"checkbox12\" type=\"checkbox\" value=\"{{comp.name}}|{{comp.autre}}\" name=\"{{comp.name}}\"><label for=\"checkbox12\">{{comp.autre}}</label>", "forms/component.html", "/home/nmoller/dev/builder/src/views/forms/component.html");
    }
}
