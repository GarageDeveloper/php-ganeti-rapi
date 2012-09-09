php-ganeti-rapi
===============

A PHP implementation of the RAPI (remote API) client for ganeti

Goals:
- create a simple php implementation of a RAPI client to help managing a
  ganeti cluster in other projects
- should be object oriented and reusable easily

What's done:
<code>
    public function getVersion() - OK
    public function getFeatures() - OK
    public function getOperatingSystems() - OK
    public function getInfo() - OK
    public function redistributeConfig() - TO BE TESTED
    public function modifyCluster - TO BE CODED/TESTED
    public function getClusterTags() - OK
    public function addClusterTags - TO BE CODED/TESTED
    public function deleteClusterTags - TO BE CODED/TESTED
    public function getInstances($bulk=FALSE) - OK
    public function getInstance($instance) - OK
</code>
   
All other methods are not written at the moment.
<pre>
  def GetInstanceInfo(self, instance, static=None):
  def CreateInstance(self, mode, name, disk_template, disks, nics,
  def DeleteInstance(self, instance, dry_run=False):
  def ModifyInstance(self, instance, **kwargs):
  def ActivateInstanceDisks(self, instance, ignore_size=None):
  def DeactivateInstanceDisks(self, instance):
  def GrowInstanceDisk(self, instance, disk, amount,
  def GetInstanceTags(self, instance):
  def AddInstanceTags(self, instance, tags, dry_run=False):
  def DeleteInstanceTags(self, instance, tags, dry_run=False):
  def RebootInstance(self, instance, reboot_type=None,
  def ShutdownInstance(self, instance, dry_run=False,
  def StartupInstance(self, instance, dry_run=False, no_remember=False):
  def ReinstallInstance(self, instance, os=None, no_startup=False,
  def ReplaceInstanceDisks(self, instance, disks=None,
  def PrepareExport(self, instance, mode):
  def ExportInstance(self, instance, mode, destination, shutdown=None,
  def MigrateInstance(self, instance, mode=None, cleanup=None):
  def FailoverInstance(self, instance, iallocator=None,
  def RenameInstance(self, instance, new_name, ip_check=None,
  def GetInstanceConsole(self, instance):
  def GetJobs(self):
  def GetJobStatus(self, job_id):
  def WaitForJobCompletion(self, job_id, period=5, retries=-1):
  def WaitForJobChange(self, job_id, fields, prev_job_info,
  def CancelJob(self, job_id, dry_run=False):
  def GetNodes(self, bulk=False):
  def GetNode(self, node):
  def EvacuateNode(self, node, iallocator=None, remote_node=None,
  def MigrateNode(self, node, mode=None, dry_run=False, iallocator=None,
  def GetNodeRole(self, node):
  def SetNodeRole(self, node, role, force=False):
  def GetNodeStorageUnits(self, node, storage_type, output_fields):
  def ModifyNodeStorageUnits(self, node, storage_type, name,
  def RepairNodeStorageUnits(self, node, storage_type, name):
  def GetNodeTags(self, node):
  def AddNodeTags(self, node, tags, dry_run=False):
  def DeleteNodeTags(self, node, tags, dry_run=False):
  def GetGroups(self, bulk=False):
  def GetGroup(self, group):
  def CreateGroup(self, name, alloc_policy=None, dry_run=False):
  def ModifyGroup(self, group, **kwargs):
  def DeleteGroup(self, group, dry_run=False):
  def RenameGroup(self, group, new_name):
  def AssignGroupNodes(self, group, nodes, force=False, dry_run=False):
  def GetGroupTags(self, group):
  def AddGroupTags(self, group, tags, dry_run=False):
  def DeleteGroupTags(self, group, tags, dry_run=False):
  def Query(self, what, fields, filter_=None):
  def QueryFields(self, what, fields=None):
</pre>
