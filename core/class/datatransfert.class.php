<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
require_once dirname(__FILE__) . '/../../core/php/datatransfert.inc.php';

class datatransfert extends eqLogic {
    public static function dependancy_info() {
        $return = array();
        $return['log'] = __CLASS__ . '_update';
        $return['progress_file'] = jeedom::getTmpFolder(__CLASS__) . '_progress';
        $state = '';
        chmod(dirname(__FILE__) . "/../../external/check.sh", 0775);
        exec(dirname(__FILE__) . "/../../external/check.sh", $out, $ret);
        if ($ret == 0) {
            $state = 'ok';
        } else {
            $state = 'nok';
        }
        $return['state'] = $state;
        return $return;
    }

    public static function dependancy_install() {
        log::remove(__CLASS__ . '_update');
        $cmd = dirname(__FILE__) . '/../../external/install.sh';
        $cmd .= ' ' . jeedom::getTmpFolder(__CLASS__) . '_progress';
        return array('script' => $cmd, 'log' => log::getPathToLog(__CLASS__ . '_update'));
    }

    public static function supportedProtocol() {
        $return = array();
        foreach (ls(dirname(__FILE__) . '/../php', '*.protocol.php') as $file) {
            $protocol = explode('.', $file);
            $return[] = $protocol[0];
        }
        return $return;
    }

    public function postSave() {
        foreach ($this->getCmd() as $tcmd) {
            if (strpos($tcmd->getName(), "_status") !== false || strpos($tcmd->getName(), "_progress") !== false)
                continue;

            $cmd = $tcmd;
            $id = $cmd->getName() . "_status";
            $logic = cmd::byEqLogicIdAndLogicalId($this->getId(), $id);
            if (!is_object($logic)) {
                $cmd = new cmd();
                $cmd->setEventOnly(1);
                $cmd->setIsHistorized(0);
                $cmd->setOrder(count($this->getCmd()));
                $cmd->setEqLogic_id($this->getId());
                $cmd->setEqType('datatransfertInfo');
                $cmd->setLogicalId($id);
                $cmd->setName($cmd->getLogicalId());
                $cmd->setType('info');
                $cmd->setSubType('string');
                $cmd->setIsVisible(false);
                $cmd->save();
            }
            $cmd = $tcmd;
            $id = $cmd->getName() . "_progress";
            $logic = cmd::byEqLogicIdAndLogicalId($this->getId(), $id);
            if (!is_object($logic)) {
                $cmd = new cmd();
                $cmd->setEventOnly(1);
                $cmd->setIsHistorized(0);
                $cmd->setOrder(count($this->getCmd()));
                $cmd->setEqLogic_id($this->getId());
                $cmd->setEqType('datatransfertInfo');
                $cmd->setLogicalId($id);
                $cmd->setName($cmd->getLogicalId());
                $cmd->setType('info');
                $cmd->setSubType('numeric');
                $cmd->setIsVisible(false);
                $cmd->save();
            }
        }
    }

    public function setUploadStatus($name, $status) {
        $logic = cmd::byEqLogicIdAndLogicalId($this->getId(), $name . "_status");
        if ($logic)
            $logic->event($status);
    }

    public function setUploadProgress($name, $progress) {
        $logic = cmd::byEqLogicIdAndLogicalId($this->getId(), $name . "_progress");
        if ($logic)
            $logic->event($progress);
        $this->protocol->log('debug', "progress " . $name . ": " . $progress);
    }

    function setProtocol($protocol) {
      $this->protocol = $protocol;
  }
}

class datatransfertCmd extends cmd {
    public static function orderFile($a, $b) {
        if ($a['datetime'] == $b['datetime']) {
            return 0;
        }
        return ($a['datetime'] < $b['datetime']) ? +1 : -1;
    }

    public static function getDirContents($dir, &$results = array()){
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir."/".$value);
            if(!is_dir($path))
                $results[] = $path;
            else if($value != "." && $value != "..")
                self::getDirContents($path, $results);
        }

        return $results;
    }

    public function ls($dir, $filter) {
        $lst = array();
        self::getDirContents($dir, $lst);
        $res = array();
        foreach ($lst as $file)  {
            if (fnmatch($filter, $file))
                array_push($res, str_replace($dir . "/", "", $file));
        }
        return $res;
    }

    public function setProgressTotal($total) {
        $this->progress = array();
        $this->progressCurrent = 0;
        $this->progressTotal = $total;
    }

    public function setProgress($id, $size) {
        $this->progress[$id] = $size;
        $total = 0;
        foreach ($this->progress as $val)
            $total = $total + $val;
        if ($this->progressTotal == 0) {
            if ($this->progressCurrent != 100) {
                $this->progressCurrent = 100;
                $this->getEqLogic()->setUploadProgress($this->getName(), 100);
            }
        } else {
            $progress = intval(100 * $total / $this->progressTotal);
            if ($this->progressCurrent != $progress) {
                $this->progressCurrent = $progress;
                if ($progress == 100 || $progress == 0 || !isset($this->progressCurrentTime) || $this->progressCurrentTime + 1 < time()) {
                    $this->progressCurrentTime = time();
                    $this->getEqLogic()->setUploadProgress($this->getName(), $progress);
                }
            }
        }
    }

    public function execute($_options = null) {
        try {
            $eqLogic = $this->getEqLogic();
            $protocol = $eqLogic->getConfiguration('protocol');
            include_file('core', $protocol . '.protocol', 'php', 'datatransfert');
            $class = call_user_func('DataTransfert\\' . $protocol . '::withEqLogic', $eqLogic);
            $class->setParentCmd($this);
            $eqLogic->setProtocol($class);
            $eqLogic->setUploadStatus($this->getName(), "uploading");
            $eqLogic->setUploadProgress($this->getName(), 0);
            $class->setProgressCallback($this);
            $cible = ltrim(rtrim($this->getConfiguration('cible'), " /"), " ");
            $source = "/" . trim(calculPath($this->getConfiguration('source')), " /");
            if (!is_dir($source))
                throw new \Exception(__('Dossier source manquant : ',__FILE__) . $source);
            $res = array();
            $filter_recentfile = $this->getConfiguration('filter_recentfile');
            if ($this->getConfiguration('filter_recentfile') != '') {
                $filelist = array();
                foreach ($this->ls($source, $this->getConfiguration('filter_file', '*')) as $file) {
                    $filelist[] = array(
                        'file' => $file,
                        'datetime' => filemtime($source . '/' . $file)
                    );
                }
                usort($filelist, 'datatransfertCmd::orderFile');
                foreach (array_slice($filelist, 0, $this->getConfiguration('filter_recentfile')) as $file)
                    array_push($res, $file['file']);
            } else {
                $res = $this->ls($source, $this->getConfiguration('filter_file', '*'));
            }
            $total = 0;
            foreach ($res as $file) {
                $total = $total + filesize($source . "/" . $file);;
            }
            $this->setProgressTotal($total);
            foreach ($res as $file) {
                $cibleF = ($cible == "/") ? ("/" . $file) : ($cible . "/" . $file);
                $class->log('info', "uploading " . $source . "/" . $file . " to " . $cibleF);
                if (dirname($file) != "" && dirname($file) != null)
                    $class->mkdir(dirname($cibleF));
                $class->put($source . "/" . $file, $cibleF);
                $class->log('info', "upload " . $source . "/" . $file . " to " . $cibleF . " complete !");
                $this->setProgress($source . "/" . $file, filesize($source . "/" . $file));
            }
            $eqLogic->setUploadStatus($this->getName(), "cleaning");
            if ($this->getConfiguration('remove_old') != "")
                $class->removeOlder($cible, $this->getConfiguration('remove_old'));
            $list = $class->ls($cible);
            $res = array();
            foreach ($list as $val)
                array_push($res, $val["alias"]);
            $class->log('info', "files on [" . $cible . "]: " . implode(",", $res));
            $eqLogic->setUploadStatus($this->getName(), "ok");
        } catch (Exception $e) {
            $eqLogic->setUploadStatus($this->getName(), "ko");
            $class->log('error', $e->getTraceAsString());
            throw $e;
        }
    }
}

class datatransfertInfo extends cmd {
}
class datatransfertInfoCmd extends cmd {
}
?>