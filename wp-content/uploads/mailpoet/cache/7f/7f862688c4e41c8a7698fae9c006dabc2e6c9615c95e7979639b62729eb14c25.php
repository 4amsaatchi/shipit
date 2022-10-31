<?php

use MailPoetVendor\Twig\Environment;
use MailPoetVendor\Twig\Error\LoaderError;
use MailPoetVendor\Twig\Error\RuntimeError;
use MailPoetVendor\Twig\Extension\SandboxExtension;
use MailPoetVendor\Twig\Markup;
use MailPoetVendor\Twig\Sandbox\SecurityError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedTagError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFilterError;
use MailPoetVendor\Twig\Sandbox\SecurityNotAllowedFunctionError;
use MailPoetVendor\Twig\Source;
use MailPoetVendor\Twig\Template;

/* newsletter/templates/blocks/woocommerceContent/customer_note.hbs */
class __TwigTemplate_eb9f002587e6d9fd3fa243fa8790b9e38cff1fdbc90d7b5cf45aca6441d906b3 extends \MailPoetVendor\Twig\Template
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
        echo "<div class=\"mailpoet_tools\"></div>
<div class=\"mailpoet_woocommerce_content_overlay\">
  <p>";
        // line 3
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Autogenerated content by WooCommerce");
        echo "</p>
</div>
<div class=\"mailpoet_content mailpoet_woocommerce_content\" data-automation-id=\"woocommerce_content\">
<p style=\"margin:0 0 16px\">";
        // line 6
        echo \MailPoetVendor\twig_escape_filter($this->env, \MailPoetVendor\twig_sprintf($this->extensions['MailPoet\Twig\I18n']->translate("Hi %s,", "woocommerce"), "Elon"), "html", null, true);
        echo "</p>
<p style=\"margin:0 0 16px\">";
        // line 7
        echo $this->extensions['MailPoet\Twig\I18n']->translate("The following note has been added to your order:", "woocommerce");
        echo "</p>
<blockquote>
<p style=\"margin:0 0 16px\">Hi Elon, welcome to MailPoet!</p>
</blockquote>
<p style=\"margin:0 0 16px\">";
        // line 11
        echo $this->extensions['MailPoet\Twig\I18n']->translate("As a reminder, here are your order details:", "woocommerce");
        echo "</p>
<h2 style=\"display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left\">
\t";
        // line 13
        echo $this->extensions['MailPoet\Twig\I18n']->translate("[Order #0001]", "woocommerce");
        echo "</h2>

<div style=\"margin-bottom:40px\">
\t<table class=\"m_3180768237544866075td\" cellspacing=\"0\" cellpadding=\"6\" border=\"1\" style=\"border:1px solid #e4e4e4;vertical-align:middle;width:100%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif\">
\t\t<thead>
\t\t\t<tr>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"col\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 19
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Product", "woocommerce");
        echo "</th>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"col\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 20
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Quantity", "woocommerce");
        echo "</th>
\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"col\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 21
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Price", "woocommerce");
        echo "</th>
\t\t\t</tr>
\t\t</thead>
\t\t<tbody>
\t\t\t\t<tr class=\"m_3180768237544866075order_item\">
\t\t<td class=\"m_3180768237544866075td\" style=\"border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word\">
\t\tMy First Product\t\t</td>
\t\t<td class=\"m_3180768237544866075td\" style=\"border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif\">
\t\t\t1\t\t</td>
\t\t<td class=\"m_3180768237544866075td\" style=\"border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif\">
\t\t\t<span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">10,00<span class=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span>\t\t</td>
\t</tr>

\t\t</tbody>
\t\t<tfoot>
\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px\">";
        // line 37
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Subtotal:", "woocommerce");
        echo "</th>
\t\t\t\t\t\t<td class=\"m_3180768237544866075td\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px\"><span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">10,00<span class=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span></td>
\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 41
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Shipping:", "woocommerce");
        echo "</th>
\t\t\t\t\t\t<td class=\"m_3180768237544866075td\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">
<span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">4,90<span class=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span>
</td>
\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 47
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Payment method:", "woocommerce");
        echo "</th>
\t\t\t\t\t\t<td class=\"m_3180768237544866075td\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">Paypal</td>
\t\t\t\t\t</tr>
\t\t\t\t\t\t\t\t\t\t<tr>
\t\t\t\t\t\t<th class=\"m_3180768237544866075td\" scope=\"row\" colspan=\"2\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">";
        // line 51
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Total:", "woocommerce");
        echo "</th>
\t\t\t\t\t\t<td class=\"m_3180768237544866075td\" style=\"border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left\">
<span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">14,90<span class=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span> <small class=\"m_3180768237544866075includes_tax\">(includes <span class=\"m_3180768237544866075woocommerce-Price-amount m_3180768237544866075amount\">0,91<span class=\"m_3180768237544866075woocommerce-Price-currencySymbol\">€</span></span> VAT)</small>
</td>
\t\t\t\t\t</tr>
\t\t\t\t\t\t\t</tfoot>
\t</table>
</div>

<table id=\"m_3180768237544866075addresses\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"width:100%;vertical-align:top;margin-bottom:40px;padding:0\">
\t<tbody><tr>
\t\t<td valign=\"top\" width=\"50%\" style=\"text-align:left;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;border:0;padding:0\">
\t\t\t<h2 style=\"display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left\">";
        // line 63
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Billing address", "woocommerce");
        echo "</h2>

\t\t\t<address class=\"m_3180768237544866075address\" style=\"padding:12px;border:1px solid #e4e4e4\">Elon Musk<br>42 rue Blue Origin<br>75000 Paris<br>France</address>
\t\t</td>
\t\t\t\t\t<td valign=\"top\" width=\"50%\" style=\"text-align:left;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;padding:0\">
\t\t\t\t<h2 style=\"display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left\">";
        // line 68
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Shipping address", "woocommerce");
        echo "</h2>

\t\t\t\t<address class=\"m_3180768237544866075address\" style=\"padding:12px;border:1px solid #e4e4e4\">Elon Musk<br>42 rue Blue Origin<br>75000 Paris<br>France</address>
\t\t\t</td>
\t\t\t</tr>
</tbody></table>
<p style=\"margin:0 0 16px\">";
        // line 74
        echo $this->extensions['MailPoet\Twig\I18n']->translate("Thanks for reading.", "woocommerce");
        echo "</p>
</div>
<div class=\"mailpoet_block_highlight\"></div>";
    }

    public function getTemplateName()
    {
        return "newsletter/templates/blocks/woocommerceContent/customer_note.hbs";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  154 => 74,  145 => 68,  137 => 63,  122 => 51,  115 => 47,  106 => 41,  99 => 37,  80 => 21,  76 => 20,  72 => 19,  63 => 13,  58 => 11,  51 => 7,  47 => 6,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "newsletter/templates/blocks/woocommerceContent/customer_note.hbs", "/home/boxcargohn/public_html/wp-content/plugins/mailpoet/views/newsletter/templates/blocks/woocommerceContent/customer_note.hbs");
    }
}
