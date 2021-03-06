@ECHO OFF

rem pick the next PECL pkg and pass to pecl_build_all.bat 
rem first try releases, if there aren't any, look for snaps

SET BAT_DIR=%~dp0

cd c:\pecl-in-pkg

for /r %%i in (*) do (
	call %BAT_DIR%pecl_build_all.bat --upload --aggregate-mail --package=%%i
	del %%i
	goto ONLY_ONE
)

cd c:\pecl-in-pkg-nomail

for /r %%i in (*) do (
	call %BAT_DIR%pecl_build_all.bat --upload --package=%%i
	del %%i
	goto ONLY_ONE
)

cd c:\pecl-in-snap

for /r %%i in (*) do (
	call %BAT_DIR%pecl_build_all.bat --upload --is-snap --aggregate-mail --package=%%i
	del %%i
	goto ONLY_ONE
)

cd c:\pecl-in-snap-nomail

for /r %%i in (*) do (
	call %BAT_DIR%pecl_build_all.bat --upload --is-snap --package=%%i
	del %%i
	goto ONLY_ONE
)

cd c:\pecl-in-pkg-56

for /r %%i in (*) do (
	call %BAT_DIR%pecl_build_56.bat --upload --aggregate-mail --package=%%i
	del %%i
	goto ONLY_ONE
)

cd c:\pecl-in-pkg-nomail-56

for /r %%i in (*) do (
	call %BAT_DIR%pecl_build_56.bat --upload --package=%%i
	del %%i
	goto ONLY_ONE
)

:ONLY_ONE
cd %BAT_DIR%
echo .

