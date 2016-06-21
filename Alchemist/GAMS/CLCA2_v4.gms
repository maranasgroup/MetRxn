OPTIONS
       decimals = 8
       solprint = off
       reslim = 3000
       iterlim = 1000000000
       domlim = 0
       work = 10000000
       lp = cplex
       threads = 8
       sysout = off
       profile = 0
       optcr = 1e-8
;
$offdigit
$inlinecom /* */

/*TODO 1: add integercuts. Integercuts on main atoms, not_pseudo_atoms !!*/
/*TODO 2: add integercuts. Integercuts on main atoms, not_pseudo_atoms using GI information!!*/
/*TODO 3: combine everything into a workflow, combine information on the number of fragments and_ number of bond breaks*/
/*TODO 4: bring in ML into this*/
SETS

r atom_set
/
$include "sets/r_atoms.index"
/

p atom_set
/
$include "sets/p_atoms.index"
/

rp(r,p) reactant_and_product atom 1:1 map possiblities
/
$include "mapping/rp_atoms.map"
/

u bond_set
/
$include "sets/u_bonds.index"
/

v bond_set
/
$include "sets/v_bonds.index"
/

uv(u,v) reactant_and_product bond 1:1 map possiblities
/
$include "mapping/uv_bonds.map"
/

N_r(r,r) immediate neighbours of r
/
$include "mapping/r.neighbours"
/

N_p(p,p) immediate neighbours of p
/
$include "mapping/p.neighbours"
/

N_u(u,r) immediate neighbours of u
/
$include "mapping/u.neighbours"
/

N_v(v,p) immediate neighbours of v
/
$include "mapping/v.neighbours"
/

rgi
/
$include "sets/rgi.index"
/
pgi
/
$include "sets/pgi.index"
/

r_gi(rgi,r)
/
$include "mapping/r_gi.map"
/

p_gi(pgi,p)
/
$include "mapping/p_gi.map"
/

r_nonTerm(r)
/
$include "mapping/r.nonTerm"
/
p_nonTerm(p)
/
$include "mapping/p.nonTerm"
/
u_nonTerm(u)
/
$include "mapping/u.nonTerm"
/
v_nonTerm(v)
/
$include "mapping/v.nonTerm"
/
cut index for integer cuts
/1*200000/
r_not(r)
p_not(p)
u_not(u)
v_not(v)
;
r_not(r) = not r_nonTerm(r);
p_not(p) = not p_nonTerm(p);
u_not(u) = not u_nonTerm(u);
v_not(v) = not v_nonTerm(v);
Alias(r,r_a);
Alias(p,p_a);
Alias(u,u_a);
Alias(v,v_a);
Alias(cut,cut_a);
PARAMETERS

IRP(r,p) Indicator weights  = n if the primes for r and p are the same at various radii until n
/
$include "parameters/rp.indicator"
/

IUV(u,v) Indicator weights  = n if the primes for u and v are the same at various radii until n
/
$include "parameters/uv.indicator"
/
YES_r(r)
/
$include "parameters/r_atoms.node"
/
YES_p(p)
/
$include "parameters/p_atoms.node"
/
store_rpgi(cut,rgi,pgi)
foundSoln(cut)
;
store_rpgi(cut,rgi,pgi) = 0;
foundSoln(cut)=0;
IRP(r_not,p_not)$rp(r_not,p_not) = 1;
IUV(u_not,v_not)$uv(u_not,v_not) = 1;

SCALAR
M /10000/
tot_1 /0/
tot_2 /0/
counter /0/
BINARY VARIABLES
y_rp(r,p)
y_uv(u,v)
y_gi(rgi,pgi)
;
VARIABLES
z
;
EQUATIONS

eq1
eq2_1
eq2_2
eq2_3
eq2_4
eq3_1
eq3_2
eq4_1
eq4_2
eq5_1
eq5_2
intcut
obj
tot_eq_1
tot_eq_2
;
eq1(rp(r,p))..           y_rp(r,p)=l=Sum((r_a,p_a)$(N_r(r,r_a) and N_p(p,p_a)), y_rp(r,p));
eq2_1(r)..               Sum(p$(rp(r,p)),y_rp(r,p))=l=1;
eq2_2(p)..               Sum(r$(rp(r,p)),y_rp(r,p))=l=1;
eq2_3(r)$(YES_r(r) = 1)..               Sum(p$(rp(r,p)),y_rp(r,p))=e=1;
eq2_4(p)$(YES_p(p) = 1)..               Sum(r$(rp(r,p)),y_rp(r,p))=e=1;
eq3_1(N_u(u,r))..        Sum(v$(uv(u,v)),y_uv(u,v))=l=Sum(p$(rp(r,p)),y_rp(r,p));
eq3_2(N_v(v,p))..        Sum(u$(uv(u,v)),y_uv(u,v))=l=Sum(r$(rp(r,p)),y_rp(r,p));
eq4_1(uv(u,v))..          y_uv(u,v)=l=IUV(u,v);
eq4_2(uv(u,v))..          2*y_uv(u,v)=l=Sum(rp(r,p)$(N_u(u,r) and N_v(v,p)),y_rp(r,p));
eq5_1(rgi,pgi)..         y_gi(rgi,pgi)=l=sum((r,p)$(rp(r,p) and r_gi(rgi,r) and p_gi(pgi,p)), y_rp(r,p));
eq5_2(rgi,pgi)..         M*y_gi(rgi,pgi)=g=sum((r,p)$(rp(r,p) and r_gi(rgi,r) and p_gi(pgi,p)), y_rp(r,p));
intcut(cut)$(foundSoln(cut) = 1)..     Sum((rgi,pgi)$(store_rpgi(cut,rgi,pgi) = 1),1-y_gi(rgi,pgi))=g=1;
obj..                    z=e=Sum(rp(r,p),IRP(r,p)*y_rp(r,p)) + Sum(uv(u,v),IUV(u,v)*y_uv(u,v)) + M*Sum(rp(r_nonTerm,p_nonTerm),y_rp(r_nonTerm,p_nonTerm)) + M*Sum(uv(u_nonTerm,v_nonTerm),y_uv(u_nonTerm,v_nonTerm));
*obj..                    z=e=Sum(rp(r,p)$(r_nonTerm(r) and p_nonTerm(p)),IRP(r,p)*y_rp(r,p)) + Sum(uv(u,v)$(u_nonTerm(u) and v_nonTerm(v)),IUV(u,v)*y_uv(u,v));
tot_eq_1..               Sum(rp(r_nonTerm,p_nonTerm),y_rp(r_nonTerm,p_nonTerm)) + Sum(uv(u_nonTerm,v_nonTerm),y_uv(u_nonTerm,v_nonTerm))=g=tot_1;
tot_eq_2..               Sum(rp(r,p),y_rp(r,p)) + Sum(uv(u,v),y_uv(u,v))=g=tot_2;

Model CLCA2
/
eq1
eq2_1
eq2_2
eq2_3
eq2_4
eq3_1
eq3_2
eq4_1
eq4_2
eq5_1
eq5_2
intcut
obj
tot_eq_1
tot_eq_2
/


scalar solnFound /1/
file file1 /CLCA4.transition/;
file1.pc=6;
put file1;
loop(cut_a,
         if(solnFound = 1,
                counter = counter + 1;
                SOLVE CLCA2 USING MIP MAXIMIZE z;

                if((CLCA2.modelstat ne 1 and CLCA2.modelstat ne 8),
                 solnFound = 0;
                );

                if((CLCA2.modelstat = 1 or CLCA2.modelstat = 8),
                  foundSoln(cut_a)=1;
                  put file1;
                  file1.ap = 1;
                  tot_1 = Sum(rp(r_nonTerm,p_nonTerm),y_rp.l(r_nonTerm,p_nonTerm)) + Sum(uv(u_nonTerm,v_nonTerm),y_uv.l(u_nonTerm,v_nonTerm));
                  tot_2 = Sum(rp(r,p),y_rp.l(r,p)) + Sum(uv(u,v),y_uv.l(u,v));
                           loop(rp(r,p)$((y_rp.l(r,p) = 1) and (YES_r(r) = 1) and (YES_p(p) = 1)),
                                   put cut_a.tl,r.tl,p.tl,z.l,tot_1,tot_2/;
                                );

                           loop((rgi,pgi)$(y_gi.l(rgi,pgi) = 1),
                                   store_rpgi(cut_a,rgi,pgi)=1;
                                );
                  );
                  putclose file1;
          );
);
