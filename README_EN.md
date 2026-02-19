# Welcome to CS2-MAP-VETO-OVERLAY
A web application for managing and displaying CS2 esports map BP (Ban & Pick) between two teams. This project is built with PHP and JavaScript, using MySQL and local JSON files for data storage.

中文:[README](https://github.com/SouthDream666/cs2-map-veto-overlay/blob/main/README.md "README")
## Features
### Multi-format Support
- BO1 (supports both Major and IEM formats)
- BO3 (standard format)
- BO5 (standard format)
- Each format features corresponding BP processes and count calculations

### Complete BP Process Management
- Real-time display of BP process status and remaining counts
- Automatic switching of BP phases (Ban Phase → Pick Phase → BP Completed)
- Support for KNIFE round option (side selection via knife round)

### Map Management
- 10 CS maps included (Ancient, Anubis, Cache, Dust2, Inferno, Mirage, Nuke, Overpass, Train, Vertigo)
- Map banning functionality to prevent duplicate selections
- Visual feedback and animation effects for map selections

### Side Selection
- Support for three side options: T (Terrorist), CT (Counter-Terrorist), and KNIFE (knife round)
- Visual differentiation for side selections (displayed in different colors)

### Multi-Language Support
- Default support for Simplified Chinese and English
- Extensible to more languages via lang.php files
- Display interface only shows English in OBS

## Purpose
Can be used to display BP results during esports broadcast production (via OBS or similar software).

## How to Install
### Prerequisites
1. A web server or virtual host with PHP installed (e.g., Apache or Nginx).
2. PHP 7.0 or higher.
3. MySQL 5.6 or higher.

------------

1. Download the source code and extract it to your web server's root directory.
2. Open config.php and configure the following settings:
```php
function dbConfig(): array
{
    return [
        'host' => '127.0.0.1', // Typically no need to modify
        'port' => '3306', // Port number
        'name' => 'cs_map_veto', // Database name
        'user' => 'cs_map_veto', // Database user
        'pass' => 'DbA*****keF', // Database password
        'charset' => 'utf8mb4', // Typically no need to modify
    ];
}
```
3. Import the cs_map_veto.sql file from the database import folder into your MySQL server.

**Congratulations! You now have a fully functional BP Overlay ready for use.

## How to Use
Open OBS, add a Browser source, and enter the URL: https://yourdomain.com/display.php
## How to Contact Me
If you encounter any issues with the application, you can send me a private message on [Discord](https://discord.com/users/1061250571723620392 "Discord"). 
For users in China, you may also reach me via private message on [Bilibili](https://space.bilibili.com/327205741 "Bilibili").
## License
This project is licensed under the MIT License — see the [LICENSE](https://github.com/SouthDream666/cs2-map-veto-overlay/blob/main/LICENSE "LICENSE") file for details.
## Acknowledgments
Special thanks to TechSanjal for their [valorant-map-veto-overlay](https://github.com/TechSanjal/valorant-map-veto-overlay "valorant-map-veto-overlay") project, which served as inspiration.

Thank you for using the CS2 Map Veto Overlay! Wish your tournaments a great success!

------------


***translated by doubao, some semantic inaccuracies may exist.***
