<?php

/* __string_template__f68ee6bd4ec3b2909406a90e4cef7bba6b4b5bddc3c524b2de92849ab9829a45 */
class __TwigTemplate_43cf2807b72f71e1dd75647ebc7800c3f0112d76cfffbc82a679d336528b6a0d extends Twig_Template
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
        echo "<p>Hi, my name is ";
        echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
        echo ".</p>";
    }

    public function getTemplateName()
    {
        return "__string_template__f68ee6bd4ec3b2909406a90e4cef7bba6b4b5bddc3c524b2de92849ab9829a45";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "__string_template__f68ee6bd4ec3b2909406a90e4cef7bba6b4b5bddc3c524b2de92849ab9829a45", "");
    }
}
