<?php


class Format
{
    public function formatDate($date)
    {
        return date('F j, Y,g:i a', strtotime($date));
    }
    public function textShorten($text, $limit=100){
        $text = $text. " ";
        $text = substr($text, 0 , $limit);
        $text = substr($text, 0 , strrpos($text, ' '))   ;
        $text = $text . ".....";
        return $text;  
    }
    public function validation ($data){
        $data = trim($data);
        $data= stripcslashes($data);
        $data=htmlspecialchars($data);
        return $data;
    }
    public function title (){
        $path = $_SERVER['SCRIPT_NAME'];
        $title = basename($path,'.php');
        if($title == 'index'){
            $title = 'homepage';

        }

        
        return  $title = ucfirst($title);
    }
    public static function removeTagHtml($content){
        return preg_replace('%
        # Match an opening or closing HTML 4.01 tag.
        </?                  # Tag opening "<" delimiter.
        (?:                  # Group for HTML 4.01 tags.
          ABBR|ACRONYM|ADDRESS|APPLET|AREA|A|BASE|BASEFONT|BDO|BIG|
          BLOCKQUOTE|BODY|BR|BUTTON|B|CAPTION|CENTER|CITE|CODE|COL|
          COLGROUP|DD|DEL|DFN|DIR|DIV|DL|DT|EM|FIELDSET|FONT|FORM|
          FRAME|FRAMESET|H\d|HEAD|HR|HTML|IFRAME|IMG|INPUT|INS|
          ISINDEX|I|KBD|LABEL|LEGEND|LI|LINK|MAP|MENU|META|NOFRAMES|
          NOSCRIPT|OBJECT|OL|OPTGROUP|OPTION|PARAM|PRE|P|Q|SAMP|
          SCRIPT|SELECT|SMALL|SPAN|STRIKE|STRONG|STYLE|SUB|SUP|S|
          TABLE|TD|TBODY|TEXTAREA|TFOOT|TH|THEAD|TITLE|TR|TT|U|UL|VAR
        )\b                  # End group of tag name alternative.
        (?:                  # Non-capture group for optional attribute(s).
          \s+                # Attributes must be separated by whitespace.
          [\w\-.:]+          # Attribute name is required for attr=value pair.
          (?:                # Non-capture group for optional attribute value.
            \s*=\s*          # Name and value separated by "=" and optional ws.
            (?:              # Non-capture group for attrib value alternatives.
              "[^"]*"        # Double quoted string.
            | \'[^\']*\'     # Single quoted string.
            | [\w\-.:]+      # Non-quoted attrib value can be A-Z0-9-._:
            )                # End of attribute value alternatives.
          )?                 # Attribute value is optional.
        )*                   # Allow zero or more attribute=value pairs
        \s*                  # Whitespace is allowed before closing delimiter.
        /?                   # Tag may be empty (with self-closing "/>" sequence.
        >                    # Opening tag closing ">" delimiter.
        | <!--.*?-->         # Or a (non-SGML compliant) HTML comment.
        | <!DOCTYPE[^>]*>    # Or a DOCTYPE.
        %six', '', $content);;
    }
}