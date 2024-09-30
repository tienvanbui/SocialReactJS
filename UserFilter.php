    <?php 

        declare(strict_types=1);

        namespace App\Models\Filters;

        use Illuminate\Database\Eloquent\Builder;
        use Illuminate\Http\Request;

        class UserFilter extends Filters {


protected $request

public function __construct(Request $request) {

$this->request = $request



 }public function getQuery(Builder $query): Builder {

return $query;

 } 


 } 

 ?>