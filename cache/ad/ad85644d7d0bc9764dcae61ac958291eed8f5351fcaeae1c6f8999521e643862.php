<?php

/* profile.html */
class __TwigTemplate_c56295e721ff5f53a5a2e95e934144f980434e4bbd0f71a5229bd9c78433af54 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html", "profile.html", 1);
        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "layout.html";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_title($context, array $blocks = array())
    {
        // line 3
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : null), "html", null, true);
        echo "
";
    }

    // line 6
    public function block_content($context, array $blocks = array())
    {
        // line 7
        echo "<h1>Components</h1>
<ul>

    ";
        // line 10
        echo twig_escape_filter($this->env, twig_var_dump($this->env, $context, (isset($context["data"]) ? $context["data"] : null)), "html", null, true);
        echo "

    <li><a href=\"/form/test\">Form</a></li>
</ul>
";
    }

    public function getTemplateName()
    {
        return "profile.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  46 => 10,  41 => 7,  38 => 6,  32 => 3,  29 => 2,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"layout.html\" %}
{% block title %}
{{name}}
{% endblock %}

{% block content %}
<h1>Components</h1>
<ul>

    {{ dump(data) }}

    <li><a href=\"/form/test\">Form</a></li>
</ul>
{% endblock %}", "profile.html", "/home/nmoller/dev/builder/src/views/profile.html");
    }
}
