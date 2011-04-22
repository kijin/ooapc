<?php

/**
 * OOAPC: An object-oriented interface to APC
 * 
 * URL: http://github.com/kijin/ooapc
 * Version: 0.1
 * 
 * Copyright (c) 2011, Kijin Sung <kijin.sung@gmail.com>
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class OOAPC
{
    public function is_enabled()
    {
        return (bool)ini_get('apc.enabled');
    }
    
    public function get($key)
    {
        return unserialize(apc_fetch($key));
    }
    
    public function set($key, $value, $ttl = 0, $ttl_compat = 0)
    {
        if ($ttl != $ttl_compat) $ttl = $ttl_compat;
        return apc_store($key, serialize($value), $ttl);
    }
    
    public function add($key, $value, $ttl = 0, $ttl_compat = 0)
    {
        if ($ttl != $ttl_compat) $ttl = $ttl_compat;
        return apc_add($key, serialize($value), $ttl);
    }
    
    public function replace($key, $value, $ttl = 0, $ttl_compat = 0)
    {
        if ($ttl != $ttl_compat) $ttl = $ttl_compat;
        if (function_exists('apc_exists'))
        {
            if (!apc_exists($key)) return false;
        }
        else
        {
            if (apc_fetch($key) === false) return false;
        }
        return apc_store($key, serialize($value), $ttl);  // Haha, this ain't atomic!
    }
    
    public function delete($key)
    {
        return apc_delete($key);
    }
    
    public function increment($key, $diff = 1)
    {
        return apc_inc($key, $diff);
    }
    
    public function decrement($key, $diff = 1)
    {
        return apc_dec($key, $diff);
    }
    
    public function flush()
    {
        return apc_clear_cache('user');
    }
}
