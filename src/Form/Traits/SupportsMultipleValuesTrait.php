<?

namespace Backalley\FormFields\Traits;


trait SupportsMultipleValuesTrait
{
    /**
     *
     */
    public $value = [];

    /**
     *
     */
    public function setValue($value)
    {
        $this->value[] = $value;
    }
}