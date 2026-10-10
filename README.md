# SlapperRotation <img src="https://poggit.pmmp.io/ci.badge/ReinfyTeam/SlapperRotation/SlapperRotation" align="right"/>
[![](https://poggit.pmmp.io/shield.state/SlapperRotation)](https://poggit.pmmp.io/p/SlapperRotation)
[![](https://poggit.pmmp.io/shield.dl.total/SlapperRotation)](https://poggit.pmmp.io/p/SlapperRotation)
[![](https://poggit.pmmp.io/shield.dl/SlapperRotation)](https://poggit.pmmp.io/p/SlapperRotation)
[![](https://poggit.pmmp.io/shield.api/SlapperRotation)](https://poggit.pmmp.io/p/SlapperRotation)<br>
Keeps Slapper entities facing nearby players within the configured view distance.

# Requirements

- PocketMine-MP API 5.0.0 or newer.
- PHP 8.1 or newer.
- The [Slapper](https://github.com/ReinfyTeam/Slapper) plugin.

SlapperRotation is maintained by ReinfyTeam. Compatibility checks in this campaign use
[Axolotl-PM](https://github.com/NhanAZ/Axolotl-PM), a PocketMine-MP-compatible
server distribution.

# Features
- Ability to configure the distance view of the Slappers.

# Disclaimer
This plugin is designed for PocketMine-MP. If you are using a fork or spoon,
please report issues to that project instead.

# How to Install?
- You must have the [Slapper](https://github.com/ReinfyTeam/Slapper) plugin.
- Just put this plugin in your `plugins/` folder, and it should work!<br>
- You can configure the plugin by accessing `plugin_data/SlapperRotation/config.yml`

# Report a Issue/Bug
You found a bug or a plugin issue?
- Contact support in the [Discord Server](https://discord.gg/v2rNeHaptd)
- Create an [Issue](https://github.com/ReinfyTeam/SlapperRotation/issues)
- Write your bug & the issue you are having with all informations including the crash or errors so I can track the issue.
- Submit the issue and be patient for a response for a solution to your problem :D

# Build and test

The build process uses [DevTools](https://github.com/NhanAZ/DevTools) to package
and validate the plugin PHAR. The PHPStan workflow analyzes the source at its
maximum configured level:

    make phpstan

The packaged plugin must retain plugin.yml, the resources/ directory and the
PHP source under src/.

# License

SlapperRotation is licensed under the Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License.
