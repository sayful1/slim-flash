<?php

namespace Sayful\SlimFlash;


class Flash extends Message
{

    /**
     * Create a new flash notifier service provider.
     *
     * @param null|array|\ArrayAccess $storage
     * @param null|string $storageKey
     */
    public function __construct(&$storage = null, $storageKey = null)
    {
        parent::__construct($storage, $storageKey);
    }

    /**
     * Get flash message
     *
     * @return mixed
     */
    public function getFlashMessage()
    {
        return $this->getFirstMessage('flash_message');
    }

    /**
     * Get overlay message
     *
     * @return mixed
     */
    public function getOverlayMessage()
    {
        return $this->getFirstMessage('flash_message_overlay');
    }

    /**
     * Create flash message
     *
     * @param  string $title
     * @param  string $message
     * @param  string $label
     * @param  string|null $key
     *
     * @return void
     */
    public function create($title, $message, $label, $key = 'flash_message')
    {
        $this->addMessage($key, [
            'title'   => $title,
            'message' => $message,
            'label'   => $label,
        ]);
    }

    /**
     * Create an overlay flash message
     *
     * @param  string $title
     * @param  string $message
     * @param  string|null $label
     *
     * @return void
     */
    public function overlay($title = null, $message = null, $label = 'success')
    {
        $num_args = func_num_args();
        $title    = $num_args >= 1 ? func_get_arg(0) : null;
        $message  = $num_args >= 2 ? func_get_arg(1) : null;
        $label    = $num_args >= 3 ? func_get_arg(2) : 'success';
        $this->create($title, $message, $label, 'flash_message_overlay');
    }

    /**
     * Create an success flash message
     *
     * @param  string $title
     * @param  string $message
     *
     * @return void
     */
    public function success($title = null, $message = null)
    {
        $num_args = func_num_args();
        $title    = $num_args >= 1 ? func_get_arg(0) : null;
        $message  = $num_args >= 2 ? func_get_arg(1) : null;
        $this->create($title, $message, 'success');
    }

    /**
     * Create an info flash message
     *
     * @param  string $title
     * @param  string $message
     *
     * @return void
     */
    public function info($title = null, $message = null)
    {
        $num_args = func_num_args();
        $title    = $num_args >= 1 ? func_get_arg(0) : null;
        $message  = $num_args >= 2 ? func_get_arg(1) : null;
        $this->create($title, $message, 'info');
    }

    /**
     * Create an warning flash message
     *
     * @param  string $title
     * @param  string $message
     *
     * @return void
     */
    public function warning($title = null, $message = null)
    {
        $num_args = func_num_args();
        $title    = $num_args >= 1 ? func_get_arg(0) : null;
        $message  = $num_args >= 2 ? func_get_arg(1) : null;
        $this->create($title, $message, 'warning');
    }

    /**
     * Create an error flash message
     *
     * @param  string $title
     * @param  string $message
     *
     * @return void
     */
    public function error($title = null, $message = null)
    {
        $num_args = func_num_args();
        $title    = $num_args >= 1 ? func_get_arg(0) : null;
        $message  = $num_args >= 2 ? func_get_arg(1) : null;
        $this->create($title, $message, 'error');
    }

    /**
     * Create an error flash message
     *
     * @param  string $title
     * @param  string $message
     *
     * @return void
     */
    public function danger($title = null, $message = null)
    {
        $num_args = func_num_args();
        $title    = $num_args >= 1 ? func_get_arg(0) : null;
        $message  = $num_args >= 2 ? func_get_arg(1) : null;
        $this->create($title, $message, 'danger');
    }
}