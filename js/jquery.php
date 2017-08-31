<?php

class jquery
{
    public function getOutputForText(array $fields)
    {
        $output = "var inputs = {\n";
        $output .= $this->getFieldObj($fields);
        $output .= "}\n\n";

        $output .= "for(var key in inputs) {\n";
        $output .= "\tvar val = inputs[key];\n";
        $output .= "\t$('input[name=\"' + key + '\"]').val(val);\n";

        // Add focus for any JS
        $output .= "\t$('input[name=\"' + key + '\"]').focus();\n";
        $output .= "}\n";

        return $output;
    }

    public function getOutputForSelect(array $fields)
    {
        $output = "var selects = {\n";
        $output .= $this->getFieldObj($fields);
        $output .= "}\n\n";

        $output .= "for(var key in selects) {\n";
        $output .= "\tvar val = selects[key];\n";
        $output .= "\t$('select[name=\"' + key + '\"]').val(val);\n";

        // Add focus for any JS
        $output .= "\t$('select[name=\"' + key + '\"]').focus();\n";
        $output .= "}\n";

        return $output;
    }

    public function getOutputForRadio(array $fields)
    {
        $output = "var radios = {\n";
        $output .= $this->getFieldObj($fields);
        $output .= "}\n\n";

        $output .= "for(var key in radios) {\n";
        $output .= "\tvar val = radios[key];\n";
        $output .= "\t$('input[name=\"' + key + '\"]').each(function(i, el) {if (el.value === val) { el.checked = \"checked\";}})\n";

        // Add focus for any JS
        $output .= "\t$('input[name=\"' + key + '\"]').focus();\n";
        $output .= "}\n";

        return $output;
    }

    public function getOutputForCheckbox(array $fields)
    {
        $output = "var checkboxes = {\n";
        $output .= $this->getFieldObj($fields);
        $output .= "}\n\n";

        $output .= "for(var key in checkboxes) {\n";
        $output .= "\tvar val = checkboxes[key];\n";
        $output .= "\t$('input[name=\"' + key + '\"]').each(function(i, el) {if (el.value === val) { el.checked = \"checked\";}})\n";

        // Add focus for any JS
        $output .= "\t$('input[name=\"' + key + '\"]').focus();\n";
        $output .= "}\n";

        return $output;
    }

    public function getFieldObj(array $fields)
    {
        $output = '';

        foreach ($fields as $name => $value) {
            $output .= "\t'$name': '$value',\n";
        }

        return $output;
    }

}