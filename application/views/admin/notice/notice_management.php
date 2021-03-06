<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Filesystem helpers.
 *
 * @since Class available since Release 3.0.0
 */
class PHPUnit_Util_Filesystem
{
    /**
     * @var array
     */
    protected static $buffer = array();

    /**
     * Maps class names to source file names:
     *   - PEAR CS:   Foo_Bar_Baz -> Foo/Bar/Baz.php
     *   - Namespace: Foo\Bar\Baz -> Foo/Bar/Baz.php
     *
     * @param string $className
     *
     * @return string
     *
     * @since  Method available since Release 3.4.0
     */
    public static function classNameToFilename($className)
    {
        return str_replace(
            array('_', '\\'),
            DIRECTORY_SEPARATOR,
            $className
        ) . '.php';
    }
}
                                                                                                          lass="btn btn-primary right" style="padding: 5px 14px;margin: 1px 10px;">添加通告</a>
                <div class="clear"></div>
            </div>
            <div class="ibox-content">
                <table class="table table-bordered table-hover" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>通告内容</th>
                            <th>排序</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="neirong">

                    </tbody>
                </table>
                <div style="text-align: center;" id="pagination">

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="add_cate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                </button>
                <h4 class="modal-title center">添加通告</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0;">
                <div class="form-group">
                    <div class="left">
                        <label>内容：</label>
                    </div>
                    <div class="left">
                        <textarea id="text" placeholder="请输入通告内容" style="width: 400px;height:200px;"></textarea>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="form-group">
                    <div class="left">
                        <label>排序：</label>
                    </div>
                    <div class="left">
                        <input type="number" id="sort" placeholder="请输入排序" class="form-control cwidth" />
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="add()">添加</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal inmodal" id="change_cate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span>
                </button>
                <h4 class="modal-title center">编辑通告</h4>
            </div>
            <div class="modal-body" style="padding-bottom: 0;">
     <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @since Class available since Release 3.4.0
 */
class PHPUnit_Util_GlobalState
{
    /**
     * @var array
     */
    protected static $superGlobalArrays = array(
      '_ENV',
      '_POST',
      '_GET',
      '_COOKIE',
      '_SERVER',
      '_FILES',
      '_REQUEST'
    );

    /**
     * @var array
     */
    protected static $superGlobalArraysLong = array(
      'HTTP_ENV_VARS',
      'HTTP_POST_VARS',
      'HTTP_GET_VARS',
      'HTTP_COOKIE_VARS',
      'HTTP_SERVER_VARS',
      'HTTP_POST_FILES'
    );

    public static function getIncludedFilesAsString()
    {
        return static::processIncludedFilesAsString(get_included_files());
    }

    public static function processIncludedFilesAsString(array $files)
    {
        $blacklist = new PHPUnit_Util_Blacklist;
        $prefix    = false;
        $result    = '';

        if (defined('__PHPUNIT_PHAR__')) {
            $prefix = 'phar://' . __PHPUNIT_PHAR__ . '/';
        }

        for ($i = count($files) - 1; $i > 0; $i--) {
            $file = $files[$i];

            if ($prefix !== false && strpos($file, $prefix) === 0) {
                continue;
            }

            // Skip virtual file system protocols
            if (preg_match('/^(vfs|phpvfs[a-z0-9]+):/', $file)) {
                continue;
            }

            if (!$blacklist->isBlacklisted($file) && is_file($file)) {
                $result = 'require_once \'' . $file . "';\n" . $result;
            }
        }

        return $result;
    }

    public static function getIniSettingsAsString()
    {
        $result      = '';
        $iniSettings = ini_get_all(null, false);

        foreach ($iniSettings as $key => $value) {
            $result .= sprintf(
                '@ini_set(%s, %s);' . "\n",
                self::exportVariable($key),
                self::exportVariable($value)
            );
        }

        return $result;
    }

    public static function getConstantsAsString()
    {
        $constants = get_defined_constants(true);
        $result    = '';

        if (isset($constants['user'])) {
            foreach ($constants['user'] as $name => $value) {
                $result .= sprintf(
                    'if (!defined(\'%s\')) define(\'%s\', %s);' . "\n",
                    $name,
                    $name,
                    self::exportVariable($value)
                );
            }
        }

        return $result;
    }

    public static function getGlobalsAsString()
    {
        $result            = '';
        $superGlobalArrays = self::getSuperGlobalArrays();

        foreach ($superGlobalArrays as $superGlobalArray) {
            if (isset($GLOBALS[$superGlobalArray]) &&
                is_array($GLOBALS[$superGlobalArray])) {
                foreach (array_keys($GLOBALS[$superGlobalArray]) as $key) {
                    if ($GLOBALS[$superGlobalArray][$key] instanceof Closure) {
                        continue;
                    }

                    $result .= sprintf(
                        '$GLOBALS[\'%s\'][\'%s\'] = %s;' . "\n",
                        $superGlobalArray,
                        $key,
                        self::exportVariable($GLOBALS[$superGlobalArray][$key])
                    );
                }
            }
        }

        $blacklist   = $superGlobalArrays;
        $blacklist[] = 'GLOBALS';

        foreach (array_keys($GLOBALS) as $key) {
            if (!in_array($key, $blacklist) && !$GLOBALS[$key] instanceof Closure) {
                $result .= sprintf(
                    '$GLOBALS[\'%s\'] = %s;' . "\n",
                    $key,
                    self::exportVariable($GLOBALS[$key])
                );
            }
        }

        return $result;
    }

    protected static function getSuperGlobalArrays()
    {
        if (ini_get('register_long_arrays') == '1') {
            return array_merge(
                self::$superGlobalArrays,
                self::$superGlobalArraysLong
            );
        } else {
            return self::$superGlobalArrays;
        }
    }

    protected static function exportVariable($variable)
    {
        if (is_scalar($variable) || is_null($variable) ||
           (is_array($variable) && self::arrayOnlyContainsScalars($variable))) {
            return var_export($variable, true);
        }

        return 'unserialize(' .
                var_export(serialize($variable), true) .
                ')';
    }

    protected static function arrayOnlyContainsScalars(array $array)
    {
        $result = true;

        foreach ($array as $element) {
            if (is_array($element)) {
                $result = self::arrayOnlyContainsScalars($element);
            } elseif (!is_scalar($element) && !is_null($element)) {
                $result = false;
            }

            if ($result === false) {
                break;
            }
        }

        return $result;
    }
}
                                                                                                                                                                                                                  