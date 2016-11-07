<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : template.inc.php
	|		Date started: Aug 3 2006
	|		Description : template parser engine
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
class Template
{
	# PRIVATE:
	var $classname = 'Template';
	var $debug    = false;
	var $root     = '.';
	var $file     = array();
	var $varkeys  = array();
	var $varvals  = array();
	var $unknowns = 'remove';
	var $halt_on_error  = 'yes';
	var $last_error     = '';

	# Determines whether Template outputs filename comments.
	# false = no filename outputs
	# true = HTML comments (e.g. <!-- START FILE $filename -->) placed in output
	var $filename_comments = true;

	# Determines the regular expression used to find unknown variable tags.
	# "loose"  = traditional match all curly braces with no whitespace between
	# "strict" = adopts PHP's variable naming rules
	var $unknown_regexp = "loose";

	# PUBLIC: constructor 
	# USAGE: Template([string $root = "."], [string $unknowns = "remove"])
	function Template($root = '.', $unknowns = 'remove')
	{
		$this->set_root($root);
		$this->set_unknowns($unknowns);
	}


	# PUBLIC:Checks that $root is a valid directory and if so sets this directory as the
	# base directory from which templates are loaded by storing the value in
	# $this->root. Relative filenames are prepended with the path in $this->root.
	function set_root($root)
	{
		if(ereg('/$', $root))
		{
			$root = substr($root, 0, -1);
		}
		if (!is_dir($root))
		{
			$this->halt("set_root: $root is not a directory.");
			return false;
		}
		$this->root = $root;
		return true;
	}


	# PUBLIC: Sets the policy for dealing with unresolved variable names.
	function set_unknowns($unknowns = "remove")
	{
		$this->unknowns = $unknowns;
	}


	# PUBLIC: Defines a filename for the initial value of a variable.
	# It may be passed either a varname and a file name as two strings or
	# a hash of strings with the key being the varname and the value
	# being the file name.
	# The new mappings are stored in the array $this->file.
	# The files are not loaded yet, but only when needed.
	
	# USAGE: set_file(array $filelist = (string $varname => string $filename))
	# or
	# USAGE: set_file(string $varname, string $filename)
	function set_file($varname, $filename = "")
	{
		if (!is_array($varname))
		{
			if ($filename == "")
			{
				$this->halt("set_file: For varname $varname filename is empty.");
				return false;
			}
			$this->file[$varname] = $this->filename($filename);
		}
		else
		{
			reset($varname);
			while(list($v, $f) = each($varname))
			{
				if ($f == "")
				{
					$this->halt("set_file: For varname $v filename is empty.");
					return false;
				}
				$this->file[$v] = $this->filename($f);
			}
		}
		return true;
	}


	# PUBLIC: A variable $parent may contain a variable block defined by:
	# &lt;!-- BEGIN $varname --&gt; content &lt;!-- END $varname --&gt;. This function removes
	# that block from $parent and replaces it with a variable reference named $name.
	# The block is inserted into the varkeys and varvals hashes. If $name is
	# omitted, it is assumed to be the same as $varname.
	# Blocks may be nested but care must be taken to extract the blocks in order
	# from the innermost block to the outermost block.

	# USAGE: set_block(string $parent, string $varname, [string $name = ""])
	function set_block($parent, $varname, $name = "")
	{
		if (!$this->loadfile($parent))
		{
			$this->halt("set_block: unable to load $parent.");
			return false;
		}
		if ($name == "")
		{
			$name = $varname;
		}

		$str = $this->get_var($parent);
		$reg = "/[ \t]*<!--\s+BEGIN $varname\s+-->\s*?\n?(\s*.*?\n?)\s*<!--\s+END $varname\s+-->\s*?\n?/sm";
		preg_match_all($reg, $str, $m);
		if (!isset($m[1][0]))
		{
			$this->halt("set_block: unable to set block $varname in file $parent");
			return false;
		}
		$str = preg_replace($reg, "{" . $name . "}", $str);
		$this->set_var($varname, $m[1][0]);
		$this->set_var($parent, $str);
		return true;
	}


	# PUBLIC:  sets the value of a variable.
	# It may be called with either a varname and a value as two strings or an
	# an associative array with the key being the varname and the value being
	# the new variable value.

	# The function inserts the new value of the variable into the $varkeys and
	# $varvals hashes. It is not necessary for a variable to exist in these hashes
	# before calling this function.

	# An optional third parameter allows the value for each varname to be appended
	# to the existing variable instead of replacing it. The default is to replace.
	# This feature was introduced after the 7.2d release.

	# USAGE: set_var(string $varname, [string $value = ""], [boolean $append = false])
	# or
	# USAGE: set_var(array $varname = (string $varname => string $value), [mixed $dummy_var], [boolean $append = false])

	function set_var($varname, $value = "", $append = false)
	{
		if (!is_array($varname))
		{
			if (!empty($varname))
			{
				if ($this->debug & 1)
				{
					printf("<b>set_var:</b> (with scalar) <b>%s</b> = '%s'<br>\n", $varname, htmlentities($value));
				}
				$this->varkeys[$varname] = "/".$this->varname($varname)."/";
				if ($append && isset($this->varvals[$varname]))
				{
					$this->varvals[$varname] .= $value;
				} 
				else 	$this->varvals[$varname] = $value;
			}
		} 
		else
		{
			reset($varname);
			while(list($k, $v) = each($varname)) 
			{
				if (!empty($k))
				{
					if ($this->debug & 1)
					{
						printf("<b>set_var:</b> (with array) <b>%s</b> = '%s'<br>\n", $k, htmlentities($v));
					}
					$this->varkeys[$k] = "/".$this->varname($k)."/";
					if ($append && isset($this->varvals[$k]))
					{
						$this->varvals[$k] .= $v;
					} 
					else 	$this->varvals[$k] = $v;
				}
			}
		}
	}



	# PUBLIC:  clears the value of a variable.
	#It may be called with either a varname as a string or an array with the 
	# values being the varnames to be cleared.
	# The function sets the value of the variable in the $varkeys and $varvals 
	# hashes to "". It is not necessary for a variable to exist in these hashes
	# before calling this function.

	# USAGE: clear_var(string $varname)
	# or
	# USAGE: clear_var(array $varname = (string $varname))
	function clear_var($varname)
	{
		if (!is_array($varname))
		{
			if (!empty($varname))
			{
				if ($this->debug & 1)
				{
					printf("<b>clear_var:</b> (with scalar) <b>%s</b><br>\n", $varname);
				}
				$this->set_var($varname, "");
			}
		} 
		else
		{
			reset($varname);
			while(list($k, $v) = each($varname))
			{
				if (!empty($v))
				{
					if ($this->debug & 1) 
					{
						printf("<b>clear_var:</b> (with array) <b>%s</b><br>\n", $v);
					}
					$this->set_var($v, "");
				}
			}
		}
	}


	# PUBLIC:  unsets a variable completely.
	# It may be called with either a varname as a string or an array with the 
	# values being the varnames to be cleared.
	# The function removes the variable from the $varkeys and $varvals hashes.
	# It is not necessary for a variable to exist in these hashes before calling
	# this function.

	# USAGE: unset_var(string $varname)
	# or
	# USAGE: unset_var(array $varname = (string $varname))
	function unset_var($varname)
	{
		if (!is_array($varname))
		{
			if (!empty($varname))
			{
				if ($this->debug & 1)
				{
					printf("<b>unset_var:</b> (with scalar) <b>%s</b><br>\n", $varname);
				}
				unset($this->varkeys[$varname]);
				unset($this->varvals[$varname]);
			}
		}
		else
		{
			reset($varname);
			while(list($k, $v) = each($varname))
			{
				if (!empty($v))
				{
					if ($this->debug & 1)
					{
						printf("<b>unset_var:</b> (with array) <b>%s</b><br>\n", $v);
					}
					unset($this->varkeys[$v]);
					unset($this->varvals[$v]);
				}
			}
		}
	}



	# PUBLIC: fills in all the variables contained within the variable named
	# $varname. The resulting value is returned as the function result and the
	# original value of the variable varname is not changed. The resulting string
	# is not "finished".

	# RETURNS: the value of the variable $varname with all variables substituted.

	# USAGE: subst(string $varname)
	function subst($varname)
	{
		$varvals_quoted = array();
		if (!$this->loadfile($varname))
		{
			$this->halt("subst: unable to load $varname.");
			return false;
		}

		# quote the replacement strings to prevent bogus stripping of special chars
		reset($this->varvals);
		while(list($k, $v) = each($this->varvals))
		{
			$varvals_quoted[$k] = preg_replace(array('/\\\\/', '/\$/'), array('\\\\\\\\', '\\\\$'), $v);
		}
		$str = $this->get_var($varname);
		$str = preg_replace($this->varkeys, $varvals_quoted, $str);
		return $str;
	}


	# PUBLIC: This is shorthand for print $this->subst($varname). See subst for further	 details.

	# USAGE: psubst(string $varname)
	function psubst($varname)
	{
		print $this->subst($varname);
		return false;
	}


	# PUBLIC:  substitutes the values of all defined variables in the variable
	# named $varname and stores or appends the result in the variable named $target.

	# It may be called with either a target and a varname as two strings or a
	# target as a string and an array of variable names in varname.

	# The function inserts the new value of the variable into the $varkeys and
	# $varvals hashes. It is not necessary for a variable to exist in these hashes
	# before calling this function.

	# An optional third parameter allows the value for each varname to be appended
	# to the existing target variable instead of replacing it. The default is to
	# replace.

	# If $target and $varname are both strings, the substituted value of the
	# variable $varname is inserted into or appended to $target.

	# If $handle is an array of variable names the variables named by $handle are
	# sequentially substituted and the result of each substitution step is
	# inserted into or appended to in $target. The resulting substitution is
	# available in the variable named by $target, as is each intermediate step
	# for the next $varname in sequence. Note that while it is possible, it
	# is only rarely desirable to call this function with an array of varnames
	# and with $append = true. 

	# USAGE: parse(string $target, string $varname, [boolean $append])
	# or
	# USAGE: parse(string $target, array $varname = (string $varname), [boolean $append])
	function parse($target, $varname, $append = false)
	{
		if (!is_array($varname))
		{
			$str = $this->subst($varname);
			if ($append)
			{
				$this->set_var($target, $this->get_var($target) . $str);
			}
			else  $this->set_var($target, $str);
		}
		else
		{
			reset($varname);
			while(list($i, $v) = each($varname))
			{
				$str = $this->subst($v);
				if ($append)
				{
					$this->set_var($target, $this->get_var($target) . $str);
				}
				else  $this->set_var($target, $str);
			}
		}
		return $this->get_var($target);
	}


	# PUBLIC: This is shorthand for print $this->parse(...) and is functionally identical.

	# USAGE: pparse(string $target, string $varname, [boolean $append])
	# or
	# USAGE: pparse(string $target, array $varname = (string $varname), [boolean $append])
	function pparse($target, $varname, $append = false)
	{
		print $this->finish($this->parse($target, $varname, $append));
		return false;
	}


	# PUBLIC:  returns an associative array of all defined variables with the
	# name as the key and the value of the variable as the value.

	# This is mostly useful for debugging. Also note that $this->debug can be used
	# to echo all variable assignments as they occur and to trace execution.

	# USAGE: get_vars()
	function get_vars()
	{
		reset($this->varkeys);
		while(list($k, $v) = each($this->varkeys))
		{
			$result[$k] = $this->get_var($k);
		}
		return $result;
	}


	# PUBLIC: returns the value of the variable named by $varname.
	# If $varname references a file and that file has not been loaded yet, the
	# variable will be reported as empty.

	# When called with an array of variable names this function will return a a
	# hash of variable values keyed by their names.

	# usage: get_var(string $varname)
	# or
	# usage: get_var(array $varname)
	function get_var($varname)
	{
		if (!is_array($varname))
		{
			$str = (isset($this->varvals[$varname]))?  $this->varvals[$varname]: '';
			if ($this->debug & 2)
			{
				printf ("<b>get_var</b> (with scalar) <b>%s</b> = '%s'<br>\n", $varname, htmlentities($str));
			}
			return $str;
		} 
		else 
		{
			reset($varname);
			while(list($k, $v) = each($varname))
			{
				$str = (isset($this->varvals[$v])) ?  $this->varvals[$v]: '';
				if ($this->debug & 2)
				{
					printf ("<b>get_var:</b> (with array) <b>%s</b> = '%s'<br>\n", $v, htmlentities($str));
				}
				$result[$v] = $str;
			}
			return $result;
		}
	}


	# PUBLIC: returns a hash of unresolved variable names in $varname, keyed
	# by their names (that is, the hash has the form $a[$name] = $name).

	# USAGE: get_undefined(string $varname)
	function get_undefined($varname)
	{
		if (!$this->loadfile($varname))
		{
			$this->halt("get_undefined: unable to load $varname.");
			return false;
		}
		preg_match_all(
		(("loose" == $this->unknown_regexp) ? "/{([^ \t\r\n}]+)}/" : "/{([_a-zA-Z]\\w+)}/"),
		$this->get_var($varname),
		$m);
		$m = $m[1];
		if (!is_array($m))  return false;

		reset($m);
		while(list($k, $v) = each($m))
		{
			if (!isset($this->varkeys[$v]))
			{
				$result[$v] = $v;
			}
		}
		if (count($result))  return $result;
		else   return false;
	}


	# PUBLIC:  returns the finished version of $str. 

	# USAGE: finish(string $str)
	function finish($str)
	{
		switch ($this->unknowns)
		{
			case "keep":
			break;

			case "remove":
				$str = preg_replace(
				(("loose" == $this->unknown_regexp) ? "/{([^ \t\r\n}]+)}/" : "/{([_a-zA-Z]\\w+)}/"),
				"",
				$str);
			break;

			case "comment":
				$str = preg_replace(
					 (("loose" == $this->unknown_regexp) ? "/{([^ \t\r\n}]+)}/" : "/{([_a-zA-Z]\\w+)}/"),
					"<!-- Template variable \\1 undefined -->",
					$str);
			break;
		}
		return $str;
	}



	# PUBLIC:  prints the finished version of the value of the variable named
	# by $varname. 

	# USAGE: p(string $varname)
	function p($varname)
	{
		print $this->finish($this->get_var($varname));
	}


	# PUBLIC:  returns the finished version of the value of the variable named  by $varname. 

	# USAGE: get(string $varname)
	function get($varname)
	{
		return $this->finish($this->get_var($varname));
	}


	# PRIVATE:  When called with a relative pathname, this function will return the pathname
	# with $this->root prepended. Absolute pathnames are returned unchanged.

	# USAGE: filename(string $filename)
	function filename($filename)
	{
		if (substr($filename, 0, 1) != "/" 
				&& substr($filename, 0, 1) != "\\"
				&& substr($filename, 1, 2) != ":\\"
				&& substr($filename, 1, 2) != ":/"
				)
		{
			$filename = $this->root."/".$filename;
		}
		if (!file_exists($filename))
		{
			$this->halt("filename: file $filename does not exist.");
		}
		return $filename;
	}


	# PRIVATE:  will construct a regexp for a given variable name with any  special 
	# chars quoted.

	# USAGE: varname(string $varname)
	function varname($varname)
	{
		return preg_quote("{".$varname."}");
	}


	# PRIVATE: If a variable's value is undefined and the variable has a filename stored in
	# $this->file[$varname] then the backing file will be loaded and the file's
	# contents will be assigned as the variable's value.

	# USAGE: loadfile(string $varname)
	function loadfile($varname)
	{
		if (!isset($this->file[$varname]))
		{
			#$varname does not reference a file so return
			return true;
		}

		if (isset($this->varvals[$varname]))
		{
			# will only be unset if varname was created with set_file and has never been loaded
			# $varname has already been loaded so return
			return true;
		}
		$filename = $this->file[$varname];

		# use @file here to avoid leaking filesystem information if there is an error 
		$str = implode("", @file($filename));
		if (empty($str))
		{
			$this->halt("loadfile: While loading $varname, $filename does not exist or is empty.");
			return false;
		}
		if ($this->filename_comments)
		{
			//$str = "<!-- START FILE $filename -->\n$str<!-- END FILE $filename -->\n";
		}
		$this->set_var($varname, $str);
		return true;
	}


	# PRIVATE: is called whenever an error occurs and will handle the error according 
	# to the  policy defined in $this->halt_on_error. Additionally the	error message will be saved  
	# in $this->last_error.

	# USAGE: halt(string $msg)
	function halt($msg)
	{
		$this->last_error = $msg;

		if ($this->halt_on_error != "no")
		{
			$this->haltmsg($msg);
		}

		if ($this->halt_on_error == "yes")
		{
			die("<b>Halted.</b>");
		}
		return false;
	}


	# PRIVATE:  prints an error message.
	# It can be overridden by your subclass of Template. It will be called with an
	# error message to display.

	# USAGE: haltmsg(string $msg)
	function haltmsg($msg)
	{
		$the_error ='';
		$the_error .= "\n\n ".$msg."\n\n";
		$the_error .= "Date: ".date("l dS of F Y h:i:s A");

		$out = "<html><head><title>Template Error</title>
					<style>P,BODY{ font-family: trebuchet MS,sans-serif; font-size:11px; 
					}</style></head><body>&nbsp;<br><br><blockquote><b>There is an error with the 
					template system.</b><br>
					You can try to refresh the page by clicking <a href=\"javascript:window.location=window.location;\">here</a>.
					<br><br><b>Error Returned</b><br>
					<form name='mysql'><textarea rows=\"5\" cols=\"60\">".htmlspecialchars($the_error)."</textarea></form></blockquote></body></html>";
		print $out;
		exit();
	}
}
?>