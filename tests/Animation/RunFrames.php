<?php

namespace League\CLImate\Tests;

trait RunFrames {

    abstract protected function shouldWrite($content, $count = 1);

    protected function runFrames1()
    {
         $this->shouldWrite("\e[m __          __\e[0m");
         $this->shouldWrite("\e[m \ \        / /\e[0m");
         $this->shouldWrite("\e[m  \ \  /\  / /\e[0m");
         $this->shouldWrite("\e[m   \ \/  \/ /\e[0m");
         $this->shouldWrite("\e[m    \  /\  /\e[0m");
         $this->shouldWrite("\e[m     \/  \/\e[0m");
         $this->shouldWrite("\e[m\e[0m");
    }

    protected function runFrames2()
    {
        $this->shouldWrite("\e[m\e[7A\r\e[K __          ______\e[0m");
        $this->shouldWrite("\e[m\r\e[K \ \        / / __ \\\e[0m");
        $this->shouldWrite("\e[m\r\e[K  \ \  /\  / / |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K   \ \/  \/ /| |  | |\e[0m");
        $this->shouldWrite("\e[m\r\e[K    \  /\  / | |__| |\e[0m");
        $this->shouldWrite("\e[m\r\e[K     \/  \/   \____/\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m");
    }

    protected function runFrames3()
    {
        $this->shouldWrite("\e[m\e[7A\r\e[K __          ______  _____\e[0m");
        $this->shouldWrite("\e[m\r\e[K \ \        / / __ \|  __ \\\e[0m");
        $this->shouldWrite("\e[m\r\e[K  \ \  /\  / / |  | | |__) |\e[0m");
        $this->shouldWrite("\e[m\r\e[K   \ \/  \/ /| |  | |  _  /\e[0m");
        $this->shouldWrite("\e[m\r\e[K    \  /\  / | |__| | | \ \\\e[0m");
        $this->shouldWrite("\e[m\r\e[K     \/  \/   \____/|_|  \_\\\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m");
    }

    protected function runFrames4()
    {
        $this->shouldWrite("\e[m\e[7A\r\e[K __          ______  _____  _  __\e[0m");
        $this->shouldWrite("\e[m\r\e[K \ \        / / __ \|  __ \| |/ /\e[0m");
        $this->shouldWrite("\e[m\r\e[K  \ \  /\  / / |  | | |__) | ' /\e[0m");
        $this->shouldWrite("\e[m\r\e[K   \ \/  \/ /| |  | |  _  /|  <\e[0m");
        $this->shouldWrite("\e[m\r\e[K    \  /\  / | |__| | | \ \| . \\\e[0m");
        $this->shouldWrite("\e[m\r\e[K     \/  \/   \____/|_|  \_\_|\_\\\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m");
    }

    protected function runFrames5()
    {
        $this->shouldWrite("\e[m\e[7A\r\e[K __          ______  _____  _  __ _____\e[0m");
        $this->shouldWrite("\e[m\r\e[K \ \        / / __ \|  __ \| |/ // ____|\e[0m");
        $this->shouldWrite("\e[m\r\e[K  \ \  /\  / / |  | | |__) | ' /| (___\e[0m");
        $this->shouldWrite("\e[m\r\e[K   \ \/  \/ /| |  | |  _  /|  <  \___ \\\e[0m");
        $this->shouldWrite("\e[m\r\e[K    \  /\  / | |__| | | \ \| . \ ____) |\e[0m");
        $this->shouldWrite("\e[m\r\e[K     \/  \/   \____/|_|  \_\_|\_\_____/\e[0m");
        $this->shouldWrite("\e[m\r\e[K\e[0m");
    }

}
