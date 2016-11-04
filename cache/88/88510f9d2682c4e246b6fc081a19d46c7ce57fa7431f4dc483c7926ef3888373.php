<?php

/* forms/creation.html */
class __TwigTemplate_1a3e23b9bc4b9b7b458c65c0d8c89f687f54710ace4b2da40d84f78cc44928d7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("layout.html", "forms/creation.html", 1);
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

    // line 3
    public function block_title($context, array $blocks = array())
    {
        // line 4
        echo "Créer ficheir json
";
    }

    // line 7
    public function block_content($context, array $blocks = array())
    {
        // line 8
        echo "<form action=\"/creation\" method=\"post\">
    <div class=\"row\">
        <div class=\"small-3 columns\">
            <label for=\"middle-label\" class=\"text-right middle\">Label</label>
        </div>
        <div class=\"small-9 columns\">
            <input type=\"text\" id=\"middle-label\" placeholder=\"Right- and middle-aligned text input\">
        </div>

        <fieldset class=\"fieldset\">
            <legend>Choisir les composants à installer</legend>

            ";
        // line 20
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["components"]) ? $context["components"] : null));
        $context['loop'] = array(
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        );
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["comp"]) {
            // line 21
            echo "            ";
            echo twig_include($this->env, $context, "forms/component.html");
            echo " <br/>
            ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['length'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['comp'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        echo "
        </fieldset>
    </div>
    <input type=\"submit\" value=\"Send\">
</form>
";
    }

    public function getTemplateName()
    {
        return "forms/creation.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  88 => 23,  71 => 21,  54 => 20,  40 => 8,  37 => 7,  32 => 4,  29 => 3,  11 => 1,);
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
Créer ficheir json
{% endblock %}

{% block content %}
<form action=\"/creation\" method=\"post\">
    <div class=\"row\">
        <div class=\"small-3 columns\">
            <label for=\"middle-label\" class=\"text-right middle\">Label</label>
        </div>
        <div class=\"small-9 columns\">
            <input type=\"text\" id=\"middle-label\" placeholder=\"Right- and middle-aligned text input\">
        </div>

        <fieldset class=\"fieldset\">
            <legend>Choisir les composants à installer</legend>

            {% for comp in components %}
            {{ include('forms/component.html') }} <br/>
            {% endfor %}

        </fieldset>
    </div>
    <input type=\"submit\" value=\"Send\">
</form>
{% endblock %}", "forms/creation.html", "/home/nmoller/dev/builder/src/views/forms/creation.html");
    }
}
