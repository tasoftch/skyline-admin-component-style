<?php
/*
 * BSD 3-Clause License
 *
 * Copyright (c) @today.year, TASoft Applications
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 *  Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 *  Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 *  Neither the name of the copyright holder nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Skyline\Admin\Style\Form\Control\Option;

use Skyline\HTML\ElementInterface;

class IntegralOptionListControl extends OptionListControl
{
	/**
	 * IntegralOptionListControl constructor.
	 * @param string $name
	 * @param string|null $identifier
	 */
	public function __construct(string $name, string $identifier = NULL)
	{
		parent::__construct($name, $identifier);
		$this->classMap["input"] = 'sky-checkbox';
	}


	protected function buildOptionInput($optionID, $optionValue): ElementInterface
	{
		$input = parent::buildOptionInput($optionID, $optionValue);
		$input["type"] = 'checkbox';
		$input["name"] = sprintf("%s[]", $this->getName());

		if(!is_integer($optionID))
			throw new \RuntimeException("Can not create integral option item for #$optionID with label $optionValue");

		if($this->getValue() & $optionID)
			$input["checked"] = 'checked';

		return $input;
	}

	/**
	 * @inheritDoc
	 */
	public function setValue($value): void
	{
		if(is_iterable($value)) {
			$integral = 0;
			foreach ($value as $v) {
				if(is_integer($v))
					$integral |= $v;
			}
			$value = $integral;
		}
		parent::setValue($value);
	}
}