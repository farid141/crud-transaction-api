<?

namespace App\Enums;

enum TransactionTypeEnum: string
{
    case IN = 'IN';
    case OUT = 'OUT';
    case EXPIRED = 'EXPIRED';
    case BROKEN = 'BROKEN';
    case OTHERS = 'OTHERS';
}
