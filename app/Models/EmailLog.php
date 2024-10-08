namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'messageContent', 'email'];

    public $timestamps = true; // Habilitar timestamps, se quiser registrar data e hora do envio
}
