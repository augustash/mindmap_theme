<!DOCTYPE html>
<!-- Sorry no IE7 support! -->
<!-- @see http://foundation.zurb.com/docs/index.html#basicHTMLMarkup -->

<!--[if IE 8]><html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php print $extra; ?>
  <?php if(!theme_get_setting('fett_js_footer')) print $scripts; ?>
  <link href='http://fonts.googleapis.com/css?family=Ropa+Sans:400,400italic' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div class="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php if(theme_get_setting('fett_js_footer')) print $scripts; ?>
  <?php print $page_bottom; ?>
  <script type="application/processing">
      int num,cnt,px,py,fadeInterval;
      Particle[] particles;
      boolean initialised=false,doClear=false;
      float lastRelease=-1,scMod,fadeAmount;

      boolean sketchFullScreen() {
        return true;
      }

      void setup() {
        size(2560, 1440);
        background(255);
        smooth();
        rectMode(CENTER_DIAMETER);
        ellipseMode(CENTER_DIAMETER);
          
        cnt=0;
        num=150;
        particles=new Particle[num];
        for(int i=0; i<num; i++) particles[i]=new Particle();

        reinit();
        px=-1;
        py=-1;
      }

      void draw() {
        if(doClear) {
          background(20,20,20);
          doClear=false;
        }

        noStroke();

        if(frameCount%fadeInterval==0) {
          fill(20,20,20, fadeAmount);
          rect(width/2,height/2, width,height);
        }  
        
        updateAuto();
        
        for(int i=0; i<num; i++) 
          if(particles[i].age>0) particles[i].update();
      }

      void reinit() {
        doClear=true;
        scMod=random(1,2);
        fadeInterval=(int)random(220,300);
        fadeAmount=random(30,60);
      //  println("fadeInterval "+fadeInterval+" scMod "+nf(scMod,0,3)+
      //    " fadeAmount "+nf(fadeAmount,0,3));
        for(int i=0; i<num; i++) particles[i].age=-1;
        initAuto();
      }

      void mousePressed() {
        reinit();
      }

      AutoMover auto[];
      int autoN;

      void initAuto() {
        autoN=(int)random(3,6);
      //  println("initAuto "+autoN);
        auto=new AutoMover[autoN];
        for(int i=0; i<autoN; i++) auto[i]=new AutoMover();
        
      }

      void updateAuto() {
        for(int i=0; i<autoN; i++) auto[i].update();
      }

      class AutoMover {
        Vec2D pos,posOld;
        float dir,dirD,speed,sc,dirCnt;
        int type,age,ageGoal,interval;
       
        
        AutoMover() {
          reinit();
        }
        
        void reinit() {
          ageGoal=(int)random(150,350);
          if(random(100)>95) ageGoal*=1.25;
          age=-(int)random(80,180);    
          pos=new Vec2D(random(width-100)+50,random(height-100)+50);
          
          
          dir=(int)random(36)*10;
          type=0;
          if(random(100)>60) type=1;
          
          interval=(int)random(2,5);    
          if(type==1) {
            interval=1;
            dir=degrees(atan2(-(pos.y-height/2),pos.x-width/2));
          }
          
          dirD=random(1,2);
          if(random(100)<50) dirD=-dirD;
          speed=random(3,6);
          
          sc=random(0.5,1);
          if(random(100)>90) sc=random(1.2,1.6);
          dirCnt=random(20,35);
          

          if(type==0) {
            if(random(100)>95) sc=random(1.5,2.25);
            else sc=random(0.8,1.2);
          }
          sc*=scMod;
          speed*=sc;
        }
        
        void update() {
          age++;
          if(age<0) return;
          else if(age>ageGoal) reinit();
          else {
            if(type==1) {
              pos.add(
                cos(radians(dir))*speed,sin(radians(dir))*speed);
                         
              dir+=dirD;
              dirD+=random(-0.2,0.2);
              dirCnt--;
              if(dirCnt<0) {
                dirD=random(1,5);
                if(random(100)<50) dirD=-dirD;
                dirCnt=random(20,35);
              }
            }
            if(age%interval==0) newParticle();   
            if(pos.x<-50 || pos.x>width+50 ||
              pos.y<-50 || pos.y>height+50) reinit();
          }
        }
        
        void newParticle() {
          int partNum,i;

          if(type==0) dir=int(random(36))*10;
          
          i=0;
          while(i<num) {
            if(particles[i].age<1) {
              float offs=random(30,90);
              if(random(100)>50) offs=-offs;
              particles[i].init(dir+offs,pos.x,pos.y,sc);
              
              break;
            }
            i++;
          }
          
          px=mouseX;
          py=mouseY;
        }
      }

      class Particle {
        Vec2D v,vD;
        float dir,dirMod,speed,sc;
        int col,age,stateCnt;
        int type;
        
        Particle() {
          v=new Vec2D(0,0);
          vD=new Vec2D(0,0);
          age=0;
        }

        void init(float _dir,float mx,float my,float _sc) {
          dir=_dir;
          sc=_sc;

          float prob=random(100);
          if(prob<80) age=15+int(random(30));
          else if(prob<99) age=45+int(random(50));
          else age=100+int(random(100));
          
          if(random(100)<80) speed=random(2)+0.5;
          else speed=random(2)+2;

          if(random(100)<80) dirMod=20;
          else dirMod=60;
          
          v.set(mx,my);
          initMove();
          dir=_dir;
          stateCnt=10;
          if(random(100)>50) col=0;
          else col=1;
          
          type=(int)random(30000)%2;
        }
          
        void initMove() {
          if(random(100)>50) dirMod=-dirMod;
          dir+=dirMod;
          
          vD.set(speed,0);
          vD.rotate(radians(dir+90));

          stateCnt=10+int(random(5));
          if(random(100)>90) stateCnt+=30;
        }
        
        void update() {
          age--;
          
          if(age>=30) {
            vD.rotate(radians(1));
            vD.mult(1.01f);
          }
          
          v.add(vD);
          if(col==0) fill(145,27,113,150);
          else fill(178,59,27,150);
          
          if(type==1) {
            if(col==0) fill(88,181,64,150);
            else fill(86,91,155,150);
          }
            
          pushMatrix();
          scale(sc);
          translate(v.x,v.y);
          rotate(radians(dir));
          rect(0,0,1,16);
          popMatrix();
          
          if(age==0) {
            if(random(100)>50) fill(236,118,22,200);
            else fill(77,165,228,200);
            float size=2+random(4);
            if(random(100)>95) size+=5;
            size*=sc;
            ellipse(v.x*sc,v.y*sc,size,size);
          }
          if(v.x<0 || v.x>width || v.y<0 || v.y>height) age=0;
          
          if(age<30) {
            stateCnt--;
            if(stateCnt==0) {
              initMove();
            }
          }
         } 
        
      }

      // General vector class for 2D vectors
      class Vec2D {
        float x,y;

        Vec2D(float _x,float _y) {
          x=_x;
          y=_y;
        }

        Vec2D(Vec2D v) {
          x=v.x;
          y=v.y;
        }

        void set(float _x,float _y) {
          x=_x;
          y=_y;
        }

        void set(Vec2D v) {
          x=v.x;
          y=v.y;
        }

        void add(float _x,float _y) {
          x+=_x;
          y+=_y;
        }

        void add(Vec2D v) {
          x+=v.x;
          y+=v.y;
        }

        void sub(float _x,float _y) {
          x-=_x;
          y-=_y;
        }

        void sub(Vec2D v) {
          x-=v.x;
          y-=v.y;
        }

        void mult(float m) {
          x*=m;
          y*=m;
        }

        void div(float m) {
          x/=m;
          y/=m;
        }

        float length() {
          return sqrt(x*x+y*y);
        }

        float angle() {
          return atan2(y,x);
        }

        void normalise() {
          float l=length();
          if(l!=0) {
            x/=l;
            y/=l;
          }
        }

        Vec2D tangent() {
          return new Vec2D(-y,x);
        }

        void rotate(float val) {
          // Due to float not being precise enough, double is used for the calculations
          double cosval=Math.cos(val);
          double sinval=Math.sin(val);
          double tmpx=x*cosval - y*sinval;
          double tmpy=x*sinval + y*cosval;

          x=(float)tmpx;
          y=(float)tmpy;
        }
      }
    </script>
</body>
</html>
