<?php

class DiscordEmbed
{
    private $api;
    public $title;
    public $description;
    public $fields;
    public $json;

    public function __construct(string $a) 
    {
        $this->api = $a;
    }

    public function _CreateEmbed(string $t, string $dsc, array $fds): void
    {
        $this->title = $t;
        $this->description = $dsc;
        $this->fields = $fds;

        $this->__create_json();

        if(count($fds) >= 0) $this->json = $this->__add_fields();
    }

    public function send(): bool
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->api);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept: application/json", "Content-Type: application/json"));

        curl_setopt($curl, CURLOPT_POSTFIELDS, $this->json);

        $resp = curl_exec($curl);
        curl_close($curl);
        if($resp) { return true; }

        return false;
    }

    public function __create_json(): void
    {
        $this->json = '{
            "embeds": [{
              "title": "'. $this->title. '",
              "description": "'. $this->description .'"
            }]
          }';
    }

    public function __add_fields(): string
    {
        $lines = explode("\n", $this->json);
        $new = '{
            "embeds": [{
              "title": "'. $this->title. '",
              "description": "'. $this->description .'"';

        if(count($this->fields) >= 0) 
        {
            $new = "$new,\n\t\t". '"fields": [';
            $c = 0;
            foreach($this->fields as $field => $value)
            {
                // "field": "value", false,
                if($c == count($this->fields)-1) 
                {
                    $new = $new. '{"name": "'. $field. '", "value": "'. $value[0]. '", "inline": '. $value[1]. '}]';
                } else { 
                    $new = $new. '{"name": "'. $field. '", "value": "'. $value[0]. '", "inline": '. $value[1]. '},';
                }
                $c++;
            }
            $new = $new. "\t\t}]\n";
        } else { return ""; }

        $new = $new. '}';

        return $new;
    }
}

?>
