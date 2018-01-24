<?php

use PHPUnit\Framework\TestCase;
use Sayful\SlimFlash\Message;

class TestMessage extends TestCase
{
    /** @test */
    function get_messages_from_previous_request()
    {
        $storage = ['slimFlash' => ['Test']];
        $flash   = new Message($storage);
        $this->assertEquals(['Test'], $flash->getMessages());
    }

    /** @test */
    public function add_message_from_an_integer_for_current_request()
    {
        $storage = ['slimFlash' => []];
        $flash   = new Message($storage);
        $flash->addMessageNow('key', 46);
        $flash->addMessageNow('key', 48);
        $messages = $flash->getMessages();
        $this->assertEquals(['46', '48'], $messages['key']);
        $this->assertArrayHasKey('slimFlash', $storage);
        $this->assertEmpty($storage['slimFlash']);
    }

    /** @test */
    public function add_message_from_string_for_current_request()
    {
        $storage = ['slimFlash' => []];
        $flash   = new Message($storage);
        $flash->addMessageNow('key', 'value');
        $messages = $flash->getMessages();
        $this->assertEquals(['value'], $messages['key']);
        $this->assertArrayHasKey('slimFlash', $storage);
        $this->assertEmpty($storage['slimFlash']);
    }

    /** @test */
    public function add_message_from_array_for_current_request()
    {
        $storage  = ['slimFlash' => []];
        $flash    = new Message($storage);
        $formData = [
            'username'     => 'Scooby Doo',
            'emailAddress' => 'scooby@mysteryinc.org',
        ];
        $flash->addMessageNow('old', $formData);
        $messages = $flash->getMessages();
        $this->assertEquals($formData, $messages['old'][0]);
        $this->assertArrayHasKey('slimFlash', $storage);
        $this->assertEmpty($storage['slimFlash']);
    }

    /** @test */
    public function add_message_from_object_for_current_request()
    {

        $storage            = ['slimFlash' => []];
        $flash              = new Message($storage);
        $user               = new \stdClass();
        $user->name         = 'Scooby Doo';
        $user->emailAddress = 'scooby@mysteryinc.org';
        $flash->addMessageNow('user', $user);
        $messages = $flash->getMessages();
        $this->assertInstanceOf(\stdClass::class, $messages['user'][0]);
        $this->assertArrayHasKey('slimFlash', $storage);
        $this->assertEmpty($storage['slimFlash']);
    }

    /** @test */
    public function add_message_from_an_integer_for_next_request()
    {
        $storage = ['slimFlash' => []];
        $flash   = new Message($storage);
        $flash->addMessage('key', 46);
        $flash->addMessage('key', 48);
        $this->assertArrayHasKey('slimFlash', $storage);
        $this->assertEquals(['46', '48'], $storage['slimFlash']['key']);
    }

    /** @test */
    public function add_message_from_string_for_next_request()
    {
        $storage = ['slimFlash' => []];
        $flash   = new Message($storage);
        $flash->addMessage('key', 'value');
        $this->assertArrayHasKey('slimFlash', $storage);
        $this->assertEquals(['value'], $storage['slimFlash']['key']);
    }

    /** @test */
    public function add_message_from_array_for_next_request()
    {
        $storage  = ['slimFlash' => []];
        $flash    = new Message($storage);
        $formData = [
            'username'     => 'Scooby Doo',
            'emailAddress' => 'scooby@mysteryinc.org',
        ];
        $flash->addMessage('old', $formData);
        $this->assertArrayHasKey('slimFlash', $storage);
        $this->assertEquals($formData, $storage['slimFlash']['old'][0]);
    }

    /** @test */
    public function add_message_from_object_for_next_request()
    {
        $storage            = ['slimFlash' => []];
        $flash              = new Message($storage);
        $user               = new \stdClass();
        $user->name         = 'Scooby Doo';
        $user->emailAddress = 'scooby@mysteryinc.org';
        $flash->addMessage('user', $user);
        $this->assertArrayHasKey('slimFlash', $storage);
        $this->assertInstanceOf(\stdClass::class, $storage['slimFlash']['user'][0]);
    }

    /** @test */
    public function get_empty_messages_from_previous_request()
    {
        $storage = [];
        $flash   = new Message($storage);
        $this->assertEquals([], $flash->getMessages());
    }

    /** @test */
    public function set_messages_for_current_request()
    {
        $storage = ['slimFlash' => ['error' => ['An error']]];
        $flash   = new Message($storage);
        $flash->addMessageNow('error', 'Another error');
        $flash->addMessageNow('success', 'A success');
        $flash->addMessageNow('info', 'An info');
        $messages = $flash->getMessages();
        $this->assertEquals(['An error', 'Another error'], $messages['error']);
        $this->assertEquals(['A success'], $messages['success']);
        $this->assertEquals(['An info'], $messages['info']);
        $this->assertArrayHasKey('slimFlash', $storage);
        $this->assertEmpty([], $storage['slimFlash']);
    }

    /** @test */
    public function set_messages_for_next_request()
    {
        $storage = [];
        $flash   = new Message($storage);
        $flash->addMessage('Test', 'Test');
        $flash->addMessage('Test', 'Test2');
        $this->assertArrayHasKey('slimFlash', $storage);
        $this->assertEquals(['Test', 'Test2'], $storage['slimFlash']['Test']);
    }

    /** @test */
    public function get_message_from_key()
    {
        $storage = ['slimFlash' => ['Test' => ['Test', 'Test2']]];
        $flash   = new Message($storage);
        $this->assertEquals(['Test', 'Test2'], $flash->getMessage('Test'));
    }

    /** @test */
    public function get_first_message_from_key()
    {
        $storage = ['slimFlash' => ['Test' => ['Test', 'Test2']]];
        $flash   = new Message($storage);
        $this->assertEquals('Test', $flash->getFirstMessage('Test'));
    }

    /** @test */
    public function get_default_first_message_if_key_Does_not_exist()
    {
        $storage = ['slimFlash' => []];
        $flash   = new Message($storage);
        $this->assertEquals('This', $flash->getFirstMessage('Test', 'This'));
    }

    /** @test */
    public function get_message_from_key_including_current()
    {
        $storage = ['slimFlash' => ['Test' => ['Test', 'Test2']]];
        $flash   = new Message($storage);
        $flash->addMessageNow('Test', 'Test3');
        $this->assertEquals(['Test', 'Test2', 'Test3'], $flash->getMessage('Test'));
    }

    /** @test */
    public function has_message()
    {
        $storage = ['slimFlash' => []];
        $flash   = new Message($storage);
        $this->assertFalse($flash->hasMessage('Test'));
        $storage = ['slimFlash' => ['Test' => ['Test']]];
        $flash   = new Message($storage);
        $this->assertTrue($flash->hasMessage('Test'));
    }

    /** @test */
    public function clear_messages()
    {
        $storage = ['slimFlash' => ['Test' => ['Test']]];
        $flash   = new Message($storage);
        $flash->addMessageNow('Now', 'hear this');
        $this->assertTrue($flash->hasMessage('Test'));
        $this->assertTrue($flash->hasMessage('Now'));
        $flash->clearMessages();
        $this->assertFalse($flash->hasMessage('Test'));
        $this->assertFalse($flash->hasMessage('Now'));
    }

    /** @test */
    public function clear_message()
    {
        $storage = ['slimFlash' => ['Test' => ['Test'], 'Foo' => ['Bar']]];
        $flash   = new Message($storage);
        $flash->addMessageNow('Now', 'hear this');
        $this->assertTrue($flash->hasMessage('Test'));
        $this->assertTrue($flash->hasMessage('Foo'));
        $this->assertTrue($flash->hasMessage('Now'));
        $flash->clearMessage('Test');
        $flash->clearMessage('Now');
        $this->assertFalse($flash->hasMessage('Test'));
        $this->assertFalse($flash->hasMessage('Now'));
        $this->assertTrue($flash->hasMessage('Foo'));
    }

    /** @test */
    public function setting_custom_storage_key()
    {
        $storage = ['some-key' => ['Test' => ['Test']]];
        $flash   = new Message($storage);
        $this->assertFalse($flash->hasMessage('Test'));
        $flash = new Message($storage, 'some-key');
        $this->assertTrue($flash->hasMessage('Test'));
    }
}